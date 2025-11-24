<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Laporan;
use App\Models\Transaksi; // Pastikan 'use' ini ada

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman utama Laporan (Menu Pilihan Laporan).
     */
    public function index(): View
    {
        return view('admin.laporan.index');
    }

    /**
     * METHOD BARU: Menampilkan halaman form filter Laporan Transaksi
     */
    public function showTransaksiForm(): View
    {
        return view('admin.laporan.laporan_transaksi_form');
    }

    /**
     * METHOD DIPERBARUI: Memproses filter dan menampilkan hasil
     */
    public function generateTransaksi(Request $request)
    {
        // ==========================================================
        // PERUBAHAN DI SINI: 'json' ditambahkan ke validasi
        // ==========================================================
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'action' => 'required|in:tampilkan,pdf,json' // Tambahkan 'json'
        ]);

        // 1. Mulai query
        $query = Transaksi::with('pelanggan') // Pastikan relasi 'pelanggan' ada di Model Transaksi
                        ->whereBetween('tanggal_transaksi', [
                            $request->tanggal_mulai . ' 00:00:00', 
                            $request->tanggal_akhir . ' 23:59:59'
                        ]);

        // 2. Terapkan filter opsional
        if ($request->filled('metode_pembayaran')) {
            $query->where('metode_pembayaran', $request->metode_pembayaran);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // 3. Ambil data
        $transaksis = $query->orderBy('tanggal_transaksi', 'desc')->get();

        // 4. Tentukan aksi (Tampilkan atau PDF)
        
        // ==========================================================
        // PERUBAHAN DI SINI: Blok 'elseif' baru untuk menangani 'json'
        // ==========================================================
        if ($request->action == 'json') {
            // --- LOGIKA UNTUK TAMPILKAN DI MODAL (AJAX) ---
            return response()->json([
                'transaksis' => $transaksis,
                'filters' => [
                    'tanggal_mulai' => $request->tanggal_mulai,
                    'tanggal_akhir' => $request->tanggal_akhir,
                    'metode_pembayaran' => $request->metode_pembayaran,
                    'status' => $request->status,
                ]
                // Total akan dihitung di sisi client (JavaScript)
            ]);
        
        } elseif ($request->action == 'pdf') {
            // --- LOGIKA UNTUK GENERATE PDF ---
            // $pdf = \PDF::loadView('admin.laporan_transaksi_pdf', compact('transaksis', 'request'));
            // ... (Logika PDF Anda)
            return "Logika PDF untuk " . $transaksis->count() . " transaksi akan ada di sini.";
        
        } else { // 'tampilkan' (fallback jika ada)
            // --- LOGIKA UNTUK TAMPILKAN DI WEB (Halaman Penuh) ---
            // Ini adalah alur lama Anda, yang sekarang tidak terpakai
            // oleh tombol "Tampilkan", tapi tetap bagus untuk disimpan.
            return view('admin.laporan.laporan_transaksi_result', compact('transaksis'));
        }
    }
}