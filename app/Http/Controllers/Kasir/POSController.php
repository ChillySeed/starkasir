<?php
// app/Http/Controllers/Kasir/PosController.php
namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // Diambil dari file Anda
use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\Golongan;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\StokBarang; // Diambil dari file Teman
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    /**
     * Menampilkan halaman POS utama.
     */
    public function index()
    {
        $produks = Produk::where('is_active', true)
            ->where('stok_sekarang', '>', 0)
            ->orderBy('nama_produk')
            ->get();
            
        $pelanggans = Pelanggan::with('golongan')->orderBy('nama')->get();
        $golongans = Golongan::all();

        return view('kasir.pos', compact('produks', 'pelanggans', 'golongans'));
    }

    /**
     * Mengambil detail produk sebagai JSON.
     */
    public function getProduk($id)
    {
        $produk = Produk::findOrFail($id);
        return response()->json($produk);
    }

    /**
     * Menyimpan transaksi baru.
     * Menggabungkan logika harga kompleks (Teman) & respon JSON (Anda).
     */
    public function storeTransaksi(Request $request)
    {
        DB::beginTransaction();
        
        try {
            $request->validate([
                'items' => 'required|array|min:1',
                'items.*.produk_id' => 'required|exists:produks,id',
                'items.*.qty' => 'required|integer|min:1',
                'pelanggan_id' => 'nullable|exists:pelanggans,id',
                'metode_pembayaran' => 'required|in:tunai,debit,kredit,qris',
                'amount_paid' => 'required|numeric|min:0',
            ]);

            // Inisialisasi dari kedua file
            $total_amount = 0;
            $total_diskon = 0;
            $items = $request->items;
            $detail_items_for_response = []; // Dari file Anda (untuk respon JSON)
            $pelanggan = null; // Dari file Teman (untuk logika harga)
            $diskonPersen = 0; // Dari file Teman
            $pelanggan_data = null; // Dari file Anda (untuk respon JSON)

            // Cek pelanggan (Gabungan)
            if ($request->pelanggan_id) {
                $pelanggan = Pelanggan::with('golongan')->find($request->pelanggan_id);
                if ($pelanggan) {
                    // Untuk respon JSON (dari Anda)
                    $pelanggan_data = ['nama' => $pelanggan->nama];
                    // Untuk kalkulasi harga (dari Teman)
                    $diskonPersen = $pelanggan->golongan->diskon_persen ?? 0;
                }
            }

            // --- LOOP 1: Kalkulasi Total (Logika dari file Teman) ---
            foreach ($items as $item) {
                $produk = Produk::find($item['produk_id']);

                // Validasi stok (dari Anda)
                if ($produk->stok_sekarang < $item['qty']) {
                    throw new \Exception('Stok untuk produk ' . $produk->nama_produk . ' tidak mencukupi.');
                }
                
                // --- Logika Harga Kompleks (dari Teman) ---
                $hargaSatuan = $produk->harga_dasar;
                
                // Cek harga berdasarkan kuantitas
                // Asumsi: Anda punya method getHargaBerdasarkanQuantity di model Produk
                if (method_exists($produk, 'getHargaBerdasarkanQuantity')) {
                    $hargaQuantity = $produk->getHargaBerdasarkanQuantity($item['qty']);
                    if ($hargaQuantity < $hargaSatuan) {
                        $hargaSatuan = $hargaQuantity;
                    }
                }
                
                // Cek harga berdasarkan golongan (jika ada pelanggan)
                if ($pelanggan && method_exists($produk, 'getHargaBerdasarkanGolongan')) {
                    $hargaGolongan = $produk->getHargaBerdasarkanGolongan($pelanggan->golongan_id);
                    if ($hargaGolongan < $hargaSatuan) {
                        $hargaSatuan = $hargaGolongan;
                    }
                }
                // --- Akhir Logika Harga Kompleks ---

                $subtotal = $hargaSatuan * $item['qty'];
                $diskonItem = ($subtotal * $diskonPersen) / 100;
                
                $total_amount += $subtotal;
                $total_diskon += $diskonItem;

                // Siapkan respon JSON (dari Anda, disisipkan ke logika Teman)
                $detail_items_for_response[] = [
                    'nama_produk' => $produk->nama_produk,
                    'qty' => $item['qty'],
                    'harga' => $hargaSatuan, // Pakai harga_satuan yang sudah dihitung
                    'subtotal' => $subtotal // Pakai subtotal sebelum diskon
                ];
            }
            // --- AKHIR LOOP 1 ---

            $grand_total = $total_amount - $total_diskon;
            $kembalian = $request->amount_paid - $grand_total;

            if ($kembalian < 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jumlah pembayaran kurang dari total yang harus dibayar.'
                ], 422);
            }

            // Create transaction (Identik di kedua file)
            $transaksi = Transaksi::create([
                'kode_transaksi' => Transaksi::generateKodeTransaksi(), // Asumsi ada method ini di model Transaksi
                'user_id' => auth()->id(),
                'pelanggan_id' => $request->pelanggan_id,
                'tanggal_transaksi' => now(),
                'total_amount' => $total_amount, // Subtotal sebelum diskon
                'total_diskon' => $total_diskon,
                'amount_paid' => $request->amount_paid,
                'kembalian' => $kembalian,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status' => 'completed',
                'catatan' => $request->catatan,
            ]);

            // --- LOOP 2: Simpan Detail & Stok (Logika dari file Teman) ---
            foreach ($items as $item) {
                $produk = Produk::find($item['produk_id']);
                
                // Kalkulasi ulang harga (Best practice, dari file Teman)
                $hargaSatuan = $produk->harga_dasar;
                if (method_exists($produk, 'getHargaBerdasarkanQuantity')) {
                    $hargaQuantity = $produk->getHargaBerdasarkanQuantity($item['qty']);
                    if ($hargaQuantity < $hargaSatuan) {
                        $hargaSatuan = $hargaQuantity;
                    }
                }
                
                $diskonPersenLoop = 0; // Reset diskon persen untuk loop ini
                if ($pelanggan && method_exists($produk, 'getHargaBerdasarkanGolongan')) {
                    $hargaGolongan = $produk->getHargaBerdasarkanGolongan($pelanggan->golongan_id);
                    if ($hargaGolongan < $hargaSatuan) {
                        $hargaSatuan = $hargaGolongan;
                    }
                    $diskonPersenLoop = $pelanggan->golongan->diskon_persen ?? 0;
                }

                $subtotal = $hargaSatuan * $item['qty'];
                $diskonItem = ($subtotal * $diskonPersenLoop) / 100;

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $item['produk_id'],
                    'qty' => $item['qty'],
                    'harga_satuan' => $hargaSatuan, // Simpan harga final
                    'diskon_persen' => $diskonPersenLoop,
                    'diskon_amount' => $diskonItem,
                    'subtotal' => $subtotal - $diskonItem, // Simpan subtotal final
                ]);

                // Update product stock
                $produk->decrement('stok_sekarang', $item['qty']);

                // Record stock movement (dari file Teman)
                // Pastikan Model StokBarang dan method recordMovement ada
                if (class_exists(StokBarang::class) && method_exists(StokBarang::class, 'recordMovement')) {
                    StokBarang::recordMovement(
                        $item['produk_id'],
                        'penjualan',
                        $item['qty'],
                        "Penjualan transaksi {$transaksi->kode_transaksi}",
                        $transaksi->id
                    );
                }
            }
            // --- AKHIR LOOP 2 ---

            // Update pelanggan stats (Identik)
            if ($request->pelanggan_id) {
                // $pelanggan sudah di-load di atas
                $pelanggan->increment('total_transaksi');
                $pelanggan->increment('total_belanja', $grand_total);
            }

            DB::commit();

            // --- Respon JSON (Logika dari file Anda) ---
            $kasir_data = [
                'nama' => auth()->user()->nama 
            ];

            $responseData = [
                'kode_transaksi' => $transaksi->kode_transaksi,
                'tanggal' => $transaksi->tanggal_transaksi->toIso8601String(),
                'kasir' => $kasir_data,
                'pelanggan' => $pelanggan_data,
                'items' => $detail_items_for_response, // Pakai array yang disiapkan di Loop 1
                'subtotal_raw' => $transaksi->total_amount,
                'diskon_raw' => $transaksi->total_diskon,
                'total_raw' => $grand_total,
                'bayar_raw' => $transaksi->amount_paid,
                'kembali_raw' => $transaksi->kembalian,
            ];

            return response()->json([
                'success' => true,
                'transaksi' => $responseData, // Kirim data yang sudah diformat
                'message' => 'Transaksi berhasil disimpan.'
            ]);
            // --- Akhir Respon JSON ---

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage() // Pesan error dari Teman
            ], 500);
        }
    }

    /**
     * Menampilkan riwayat transaksi dengan filter tanggal.
     * (Logika dari file Anda)
     */
    public function riwayatTransaksi(Request $request) // Tambahkan Request $request
    {
        $query = Transaksi::with(['user', 'pelanggan', 'detailTransaksis.produk'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_transaksi', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_transaksi', '<=', $request->end_date);
        }

        $transaksis = $query->paginate(20)->appends($request->query());

        return view('kasir.riwayat', compact('transaksis'));
    }

    /**
     * Menampilkan detail transaksi (halaman terpisah).
     */
    public function showTransaksi(Transaksi $transaksi)
    {
        $transaksi->load(['user', 'pelanggan.golongan', 'detailTransaksis.produk']);
        return view('kasir.detail-transaksi', compact('transaksi'));
    }

    /**
     * Mengambil data transaksi tunggal sebagai JSON untuk struk modal.
     * (Logika dari file Anda)
     */
    public function getTransaksiJson(Transaksi $transaksi)
    {
        try {
            $transaksi->load(['user', 'pelanggan', 'detailTransaksis.produk']);

            $items = [];
            foreach ($transaksi->detailTransaksis as $detail) {
                $nama_produk = $detail->produk ? $detail->produk->nama_produk : 'Produk Dihapus';
                
                $items[] = [
                    'nama_produk' => $nama_produk,
                    'qty' => $detail->qty,
                    'harga' => $detail->harga_satuan, // Ambil harga satuan final
                    'subtotal' => $detail->harga_satuan * $detail->qty // Hitung subtotal sebelum diskon
                ];
            }

            $kasir_data = [
                'nama' => $transaksi->user ? $transaksi->user->nama : 'N/A'
            ];

            $pelanggan_data = null;
            if ($transaksi->pelanggan) {
                $pelanggan_data = ['nama' => $transaksi->pelanggan->nama];
            }
            
            $grand_total = $transaksi->total_amount - $transaksi->total_diskon;

            $responseData = [
                'kode_transaksi' => $transaksi->kode_transaksi,
                'tanggal' => $transaksi->tanggal_transaksi->toIso8601String(),
                'kasir' => $kasir_data,
                'pelanggan' => $pelanggan_data,
                'items' => $items,
                'subtotal_raw' => $transaksi->total_amount,
                'diskon_raw' => $transaksi->total_diskon,
                'total_raw' => $grand_total,
                'bayar_raw' => $transaksi->amount_paid,
                'kembali_raw' => $transaksi->kembalian,
            ];

            return response()->json([
                'success' => true,
                'transaksi' => $responseData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data: ' . $e->getMessage()
            ], 500);
        }
    }
}