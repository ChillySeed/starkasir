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
        $jenisPerubahan = ['penjualan', 'pembelian', 'adjustment', 'retur'];

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

    public function createAdjustment()
    {
        $produks = Produk::where('is_active', true)->orderBy('nama_produk')->get();
        return view('admin.stok-barang.adjustment', compact('produks'));
    }

    public function storeAdjustment(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'qty_masuk' => 'required_without:qty_keluar|integer|min:0',
            'qty_keluar' => 'required_without:qty_masuk|integer|min:0',
            'keterangan' => 'required|string|max:500',
            'tanggal_perubahan' => 'required|date',
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        // Calculate new stock
        $qtyMasuk = $request->qty_masuk ?? 0;
        $qtyKeluar = $request->qty_keluar ?? 0;
        $stokAwal = $produk->stok_sekarang;
        $stokAkhir = $stokAwal + $qtyMasuk - $qtyKeluar;

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
            'jenis_perubahan' => 'adjustment',
            'keterangan' => $request->keterangan,
            'transaksi_id' => null,
            'tanggal_perubahan' => Carbon::parse($request->tanggal_perubahan),
        ]);

        // Update product stock
        $produk->update([
            'stok_sekarang' => $stokAkhir,
        ]);

        return redirect()->route('admin.stok-barang.index')
            ->with('success', 'Adjustment stok berhasil dilakukan.');
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

        // In a real application, you would generate Excel or PDF here
        // For now, we'll just return a view with the data
        return view('admin.stok-barang.export', compact('stokBarangs'));
    }
}