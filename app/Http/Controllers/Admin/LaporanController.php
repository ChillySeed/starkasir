<?php
// app/Http\Controllers\Admin\LaporanController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Transaksi;
use App\Models\StokBarang;
use App\Models\Produk;
use App\Models\Laporan as LaporanModel;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Menampilkan Menu Utama Laporan
     */
    public function index(): View
    {
        return view('admin.laporan.index');
    }

    // ==========================================================
    // BAGIAN 1: LAPORAN TRANSAKSI (PENJUALAN)
    // ==========================================================

    public function showTransaksiForm(): View
    {
        return view('admin.laporan.laporan_transaksi_form');
    }

    public function generateTransaksi(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'action' => 'required|in:tampilkan,pdf,json'
        ]);

        // Query Transaksi
        $query = Transaksi::with(['pelanggan', 'user', 'detailTransaksis.produk'])
                        ->whereBetween('tanggal_transaksi', [
                            $request->tanggal_mulai . ' 00:00:00', 
                            $request->tanggal_akhir . ' 23:59:59'
                        ]);

        if ($request->filled('metode_pembayaran')) {
            $query->where('metode_pembayaran', $request->metode_pembayaran);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $transaksis = $query->orderBy('tanggal_transaksi', 'desc')->get();

        if ($request->action == 'json') {
            return response()->json([
                'transaksis' => $transaksis,
                'filters' => [
                    'tanggal_mulai' => $request->tanggal_mulai,
                    'tanggal_akhir' => $request->tanggal_akhir,
                    'metode_pembayaran' => $request->metode_pembayaran,
                    'status' => $request->status,
                ]
            ]);
        } elseif ($request->action == 'pdf') {
            return "Logika PDF Transaksi (Belum Diimplementasikan)";
        } else {
            return view('admin.laporan.laporan_transaksi_result', compact('transaksis'));
        }
    }

    // ==========================================================
    // BAGIAN 2: LAPORAN PEMBELIAN (STOK MASUK)
    // ==========================================================

    public function showPembelianForm(): View
    {
        return view('admin.laporan.laporan_pembelian_form');
    }

    public function generatePembelian(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'action' => 'required|in:tampilkan,pdf,json'
        ]);

        // Query StokBarang untuk stok masuk (pembelian, adjustment masuk, retur)
        $query = StokBarang::with(['produk'])
                        ->where(function($q) {
                            $q->where('jenis_perubahan', 'pembelian')
                              ->orWhere('jenis_perubahan', 'adjustment_masuk')
                              ->orWhere('jenis_perubahan', 'retur')
                              ->orWhere('jenis_perubahan', 'adjustment')
                              ->orWhere('jenis_perubahan', 'lainnya');
                        })
                        ->where('qty_masuk', '>', 0)
                        ->whereBetween('tanggal_perubahan', [
                            $request->tanggal_mulai . ' 00:00:00', 
                            $request->tanggal_akhir . ' 23:59:59'
                        ]);

        // Filter by jenis perubahan if provided
        if ($request->filled('jenis_perubahan')) {
            $query->where('jenis_perubahan', $request->jenis_perubahan);
        }

        $stokMasuk = $query->orderBy('tanggal_perubahan', 'desc')->get();

        if ($request->action == 'json') {
            return response()->json([
                'stok_masuk' => $stokMasuk,
                'filters' => [
                    'tanggal_mulai' => $request->tanggal_mulai,
                    'tanggal_akhir' => $request->tanggal_akhir,
                    'jenis_perubahan' => $request->jenis_perubahan,
                ]
            ]);
        } elseif ($request->action == 'pdf') {
            return "Logika PDF Pembelian (Belum Diimplementasikan)";
        } else {
            return view('admin.laporan.laporan_pembelian_result', compact('stokMasuk'));
        }
    }

    // ==========================================================
    // BAGIAN 3: LAPORAN LABA RUGI
    // ==========================================================

    public function showLabaRugiForm(): View
    {
        return view('admin.laporan.laporan_labarugi_form');
    }

    public function generateLabaRugi(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'action' => 'required|in:tampilkan,pdf,json'
        ]);

        // 1. AMBIL DATA PENJUALAN
        $penjualanQuery = Transaksi::with(['pelanggan', 'detailTransaksis'])
                            ->where('status', 'completed')
                            ->whereBetween('tanggal_transaksi', [
                                $request->tanggal_mulai . ' 00:00:00', 
                                $request->tanggal_akhir . ' 23:59:59'
                            ]);

        $listPenjualan = $penjualanQuery->orderBy('tanggal_transaksi', 'desc')->get();
        $totalPenjualan = $listPenjualan->sum('total_amount');
        $totalDiskon = $listPenjualan->sum('total_diskon');

        // 2. AMBIL DATA PEMBELIAN DARI STOK BARANG
        $pembelianQuery = StokBarang::with('produk')
                            ->whereIn('jenis_perubahan', ['pembelian', 'adjustment_masuk', 'retur', 'lainnya'])
                            ->where('qty_masuk', '>', 0)
                            ->whereBetween('tanggal_perubahan', [
                                $request->tanggal_mulai . ' 00:00:00', 
                                $request->tanggal_akhir . ' 23:59:59'
                            ]);

        $listPembelian = $pembelianQuery->orderBy('tanggal_perubahan', 'desc')->get();
        
        // Calculate total purchase cost
        $totalPembelian = $listPembelian->sum(function ($item) {
            return $item->qty_masuk * $item->produk->harga_dasar;
        });

        // 3. Calculate Harga Pokok Penjualan (HPP)
        $hpp = 0;
        foreach ($listPenjualan as $transaksi) {
            foreach ($transaksi->detailTransaksis as $detail) {
                $hpp += $detail->qty * $detail->produk->harga_dasar;
            }
        }

        // 4. Calculate Laba Kotor
        $labaKotor = $totalPenjualan - $hpp;

        $dataLabaRugi = [
            'summary' => [
                'pendapatan' => $totalPenjualan,
                'diskon' => $totalDiskon,
                'pengeluaran' => $totalPembelian,
                'hpp' => $hpp,
                'laba_kotor' => $labaKotor,
            ],
            'details' => [
                'penjualan' => $listPenjualan,
                'pembelian' => $listPembelian
            ],
            'periode' => [
                'mulai' => $request->tanggal_mulai,
                'akhir' => $request->tanggal_akhir
            ]
        ];

        if ($request->action == 'json') {
            return response()->json([
                'data' => $dataLabaRugi
            ]);
        } elseif ($request->action == 'pdf') {
            return "Logika PDF Laba Rugi (Belum Diimplementasikan)";
        }
    }
}