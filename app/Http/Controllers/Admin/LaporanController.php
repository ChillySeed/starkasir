<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Transaksi;
use App\Models\Pembelian; 

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
        $query = Transaksi::with('pelanggan')
                        ->whereBetween('tanggal_transaksi', [
                            $request->tanggal_mulai . ' 00:00:00', 
                            $request->tanggal_akhir . ' 23:59:59'
                        ]);

        if ($request->filled('metode_pembayaran')) {
            $query->where('metode_pembayaran', $request->metode_pembayaran);
        }
        
        // FILTER STATUS DIHAPUS (Sesuai Database Anda)
        // if ($request->filled('status')) { $query->where('status', $request->status); }
        
        $transaksis = $query->orderBy('tanggal_transaksi', 'desc')->get();

        if ($request->action == 'json') {
            return response()->json([
                'transaksis' => $transaksis,
                'filters' => [
                    'tanggal_mulai' => $request->tanggal_mulai,
                    'tanggal_akhir' => $request->tanggal_akhir,
                    'metode_pembayaran' => $request->metode_pembayaran,
                ]
            ]);
        } elseif ($request->action == 'pdf') {
            return "Logika PDF Transaksi (Belum Diimplementasikan)";
        } else {
            // Fallback jika diakses tanpa AJAX
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

        // Query Pembelian
        // Pastikan nama kolom tanggal di DB adalah 'tanggal_pembelian'
        $query = Pembelian::with('supplier') 
                        ->whereBetween('tanggal_pembelian', [
                            $request->tanggal_mulai . ' 00:00:00', 
                            $request->tanggal_akhir . ' 23:59:59'
                        ]);

        // FILTER STATUS DIHAPUS (Sesuai Database Anda)
        // if ($request->filled('status')) { $query->where('status', $request->status); }
        
        $pembelians = $query->orderBy('tanggal_pembelian', 'desc')->get();

        if ($request->action == 'json') {
            return response()->json([
                'data' => $pembelians,
                'filters' => [
                    'tanggal_mulai' => $request->tanggal_mulai,
                    'tanggal_akhir' => $request->tanggal_akhir,
                ]
            ]);
        
        } elseif ($request->action == 'pdf') {
            return "Logika PDF Pembelian (Belum Diimplementasikan)";
        }
    }

    // ==========================================================
    // BAGIAN 3: LAPORAN LABA RUGI (DENGAN RINCIAN)
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

        // 1. AMBIL DATA PENJUALAN (Detail & Total)
        $penjualanQuery = Transaksi::with('pelanggan')
                            ->whereBetween('tanggal_transaksi', [
                                $request->tanggal_mulai . ' 00:00:00', 
                                $request->tanggal_akhir . ' 23:59:59'
                            ]);
                            // ->where('status', 'lunas'); // Hapus filter status

        $listPenjualan = $penjualanQuery->orderBy('tanggal_transaksi', 'desc')->get();
        $totalPenjualan = $listPenjualan->sum('total_amount');

        // 2. AMBIL DATA PEMBELIAN (Detail & Total)
        $pembelianQuery = Pembelian::with('supplier')
                            ->whereBetween('tanggal_pembelian', [
                                $request->tanggal_mulai . ' 00:00:00', 
                                $request->tanggal_akhir . ' 23:59:59'
                            ]);
                            // ->where('status', 'lunas'); // Hapus filter status

        $listPembelian = $pembelianQuery->orderBy('tanggal_pembelian', 'desc')->get();
        $totalPembelian = $listPembelian->sum('total_biaya');

        // 3. Hitung Laba Bersih
        $labaBersih = $totalPenjualan - $totalPembelian;

        // Struktur Data Lengkap (Summary + Details)
        $dataLabaRugi = [
            'summary' => [
                'pendapatan' => $totalPenjualan,
                'pengeluaran' => $totalPembelian,
                'laba_bersih' => $labaBersih,
            ],
            'details' => [
                'penjualan' => $listPenjualan, // Kirim detail transaksi
                'pembelian' => $listPembelian  // Kirim detail pembelian
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