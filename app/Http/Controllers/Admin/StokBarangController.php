<?php
// app/Http/Controllers/Admin/StokBarangController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StokBarang;
use App\Models\Produk;
use Carbon\Carbon;

class StokBarangController extends Controller
{
    public function index(Request $request)
    {
        $query = StokBarang::with(['produk', 'transaksi']);

        // Filter by date range
        if ($request->has('tanggal_mulai') && $request->has('tanggal_akhir')) {
            $tanggalMulai = Carbon::parse($request->tanggal_mulai)->startOfDay();
            $tanggalAkhir = Carbon::parse($request->tanggal_akhir)->endOfDay();
            $query->whereBetween('tanggal_perubahan', [$tanggalMulai, $tanggalAkhir]);
        } else {
            // Default to last 30 days
            $tanggalMulai = Carbon::now()->subDays(30)->startOfDay();
            $tanggalAkhir = Carbon::now()->endOfDay();
            $query->whereBetween('tanggal_perubahan', [$tanggalMulai, $tanggalAkhir]);
        }

        // Filter by product
        if ($request->has('produk_id') && $request->produk_id) {
            $query->where('produk_id', $request->produk_id);
        }

        // Filter by jenis perubahan
        if ($request->has('jenis_perubahan') && $request->jenis_perubahan) {
            $query->where('jenis_perubahan', $request->jenis_perubahan);
        }

        $stokBarangs = $query->orderBy('tanggal_perubahan', 'desc')
            ->paginate(10);

        $produks = Produk::where('is_active', true)->orderBy('nama_produk')->get();
        $jenisPerubahan = StokBarang::getJenisPerubahanOptions();

        return view('admin.stok-barang.index', compact(
            'stokBarangs', 
            'produks', 
            'jenisPerubahan'
        ));
    }

    public function show(Produk $produk, Request $request)
    {
        $query = $produk->stokBarangs()->with('transaksi');

        // Filter by date range
        if ($request->has('tanggal_mulai') && $request->has('tanggal_akhir')) {
            $tanggalMulai = Carbon::parse($request->tanggal_mulai)->startOfDay();
            $tanggalAkhir = Carbon::parse($request->tanggal_akhir)->endOfDay();
            $query->whereBetween('tanggal_perubahan', [$tanggalMulai, $tanggalAkhir]);
        } else {
            // Default to last 30 days
            $tanggalMulai = Carbon::now()->subDays(30)->startOfDay();
            $tanggalAkhir = Carbon::now()->endOfDay();
            $query->whereBetween('tanggal_perubahan', [$tanggalMulai, $tanggalAkhir]);
        }

        $stokBarangs = $query->orderBy('tanggal_perubahan', 'desc')
            ->paginate(10);

        $totalMasuk = $produk->stokBarangs()
            ->whereBetween('tanggal_perubahan', [$tanggalMulai, $tanggalAkhir])
            ->sum('qty_masuk');

        $totalKeluar = $produk->stokBarangs()
            ->whereBetween('tanggal_perubahan', [$tanggalMulai, $tanggalAkhir])
            ->sum('qty_keluar');

        return view('admin.stok-barang.show', compact(
            'produk',
            'stokBarangs',
            'totalMasuk',
            'totalKeluar'
        ));
    }

    public function create()
    {
        $produks = Produk::where('is_active', true)->orderBy('nama_produk')->get();
        $jenisPerubahan = StokBarang::getJenisPerubahanOptions();
        
        return view('admin.stok-barang.create', compact('produks', 'jenisPerubahan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jenis_perubahan' => 'required|in:pembelian,adjustment,retur,lainnya',
            'quantity' => 'required|integer|min:1',
            'keterangan' => 'required|string|max:500',
            'tanggal_perubahan' => 'required|date',
        ]);

        $produk = Produk::findOrFail($request->produk_id);
        $stokAwal = $produk->stok_sekarang;

        // Calculate new stock based on type
        switch ($request->jenis_perubahan) {
            case 'pembelian':
            case 'retur':
            case 'lainnya':
                // These types increase stock
                $qtyMasuk = $request->quantity;
                $qtyKeluar = 0;
                $stokAkhir = $stokAwal + $qtyMasuk;
                break;
            
            case 'adjustment':
                // For adjustment, quantity can be positive or negative
                if ($request->quantity >= 0) {
                    $qtyMasuk = $request->quantity;
                    $qtyKeluar = 0;
                    $stokAkhir = $stokAwal + $qtyMasuk;
                } else {
                    $qtyMasuk = 0;
                    $qtyKeluar = abs($request->quantity);
                    $stokAkhir = $stokAwal - $qtyKeluar;
                }
                break;
            
            default:
                return redirect()->back()->with('error', 'Jenis perubahan tidak valid.');
        }

        if ($stokAkhir < 0) {
            return redirect()->back()->with('error', 'Stok akhir tidak boleh minus.');
        }

        // Create stock movement record
        StokBarang::create([
            'produk_id' => $request->produk_id,
            'qty_awal' => $stokAwal,
            'qty_keluar' => $qtyKeluar,
            'qty_masuk' => $qtyMasuk,
            'qty_akhir' => $stokAkhir,
            'jenis_perubahan' => $request->jenis_perubahan,
            'keterangan' => $request->keterangan,
            'transaksi_id' => null,
            'tanggal_perubahan' => Carbon::parse($request->tanggal_perubahan),
        ]);

        // Update product stock
        $produk->update([
            'stok_sekarang' => $stokAkhir,
        ]);

        return redirect()->route('admin.stok-barang.index')
            ->with('success', 'Perubahan stok berhasil dicatat.');
    }

    public function export(Request $request)
    {
        $query = StokBarang::with(['produk', 'transaksi']);

        // Apply filters
        if ($request->has('tanggal_mulai') && $request->has('tanggal_akhir')) {
            $tanggalMulai = Carbon::parse($request->tanggal_mulai)->startOfDay();
            $tanggalAkhir = Carbon::parse($request->tanggal_akhir)->endOfDay();
            $query->whereBetween('tanggal_perubahan', [$tanggalMulai, $tanggalAkhir]);
        }

        if ($request->has('produk_id') && $request->produk_id) {
            $query->where('produk_id', $request->produk_id);
        }

        if ($request->has('jenis_perubahan') && $request->jenis_perubahan) {
            $query->where('jenis_perubahan', $request->jenis_perubahan);
        }

        $stokBarangs = $query->orderBy('tanggal_perubahan', 'desc')->get();

        return view('admin.stok-barang.export', compact('stokBarangs'));
    }

    // Keep the old adjustment methods for backward compatibility, but mark as deprecated
    public function createAdjustment()
    {
        $produks = Produk::where('is_active', true)->orderBy('nama_produk')->get();
        $jenisPerubahanOptions = StokBarang::getJenisPerubahanOptions();
        
        return view('admin.stok-barang.adjustment', compact('produks', 'jenisPerubahanOptions'));
    }

    public function storeAdjustment(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jenis_perubahan' => 'required|in:pembelian,adjustment_masuk,adjustment_keluar,retur,lainnya',
            'quantity' => 'required|integer|min:1',
            'keterangan' => 'required|string|max:500',
            'tanggal_perubahan' => 'required|date',
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        // Calculate new stock based on jenis perubahan
        $stokAwal = $produk->stok_sekarang;
        
        switch ($request->jenis_perubahan) {
            case 'pembelian':
            case 'adjustment_masuk':
            case 'retur':
                $stokAkhir = $stokAwal + $request->quantity;
                break;
            case 'adjustment_keluar':
            case 'lainnya':
                $stokAkhir = $stokAwal - $request->quantity;
                if ($stokAkhir < 0) {
                    return redirect()->back()->with('error', 'Stok akhir tidak boleh minus.');
                }
                break;
        }

        // Create stock movement record
        StokBarang::create([
            'produk_id' => $request->produk_id,
            'qty_awal' => $stokAwal,
            'qty_keluar' => in_array($request->jenis_perubahan, ['adjustment_keluar', 'lainnya']) ? $request->quantity : 0,
            'qty_masuk' => in_array($request->jenis_perubahan, ['pembelian', 'adjustment_masuk', 'retur']) ? $request->quantity : 0,
            'qty_akhir' => $stokAkhir,
            'jenis_perubahan' => $request->jenis_perubahan,
            'keterangan' => $request->keterangan,
            'transaksi_id' => null,
            'tanggal_perubahan' => Carbon::parse($request->tanggal_perubahan),
        ]);

        // Update product stock
        $produk->update([
            'stok_sekarang' => $stokAkhir,
        ]);

        return redirect()->route('admin.stok-barang.index')
            ->with('success', 'Perubahan stok berhasil dilakukan.');
    }
}