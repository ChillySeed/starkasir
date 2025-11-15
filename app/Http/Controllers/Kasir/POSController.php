<?php
// app/Http/Controllers/Kasir/PosController.php
namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\Golongan;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
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

    public function getProduk($id)
    {
        $produk = Produk::findOrFail($id);
        return response()->json($produk);
    }

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

            // Calculate totals
            $total_amount = 0;
            $total_diskon = 0;
            $items = $request->items;
            
            // Get pelanggan diskon
            $diskon_persen = 0;
            if ($request->pelanggan_id) {
                $pelanggan = Pelanggan::with('golongan')->find($request->pelanggan_id);
                $diskon_persen = $pelanggan->golongan->diskon_persen ?? 0;
            }

            foreach ($items as $item) {
                $produk = Produk::find($item['produk_id']);
    
                // Start with base price
                $hargaSatuan = $produk->harga_dasar;
                
                // Check for quantity-based pricing
                $hargaQuantity = $produk->getHargaBerdasarkanQuantity($item['qty']);
                if ($hargaQuantity < $hargaSatuan) {
                    $hargaSatuan = $hargaQuantity;
                }
                
                // Check for golongan-based pricing if customer selected
                if ($request->pelanggan_id) {
                    $pelanggan = Pelanggan::with('golongan')->find($request->pelanggan_id);
                    $hargaGolongan = $produk->getHargaBerdasarkanGolongan($pelanggan->golongan_id);
                    
                    // Use the lowest price between all available pricing
                    if ($hargaGolongan < $hargaSatuan) {
                        $hargaSatuan = $hargaGolongan;
                    }
                    
                    // Apply golongan discount if no special price set
                    $diskonPersen = $pelanggan->golongan->diskon_persen;
                } else {
                    $diskonPersen = 0;
                }
                
                $subtotal = $hargaSatuan * $item['qty'];
                $diskonItem = ($subtotal * $diskonPersen) / 100;
                
                $total_amount += $subtotal;
                $total_diskon += $diskonItem;
            }

            $grand_total = $total_amount - $total_diskon;
            $kembalian = $request->amount_paid - $grand_total;

            if ($kembalian < 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jumlah pembayaran kurang dari total yang harus dibayar.'
                ], 422);
            }

            // Create transaction
            $transaksi = Transaksi::create([
                'kode_transaksi' => Transaksi::generateKodeTransaksi(),
                'user_id' => auth()->id(),
                'pelanggan_id' => $request->pelanggan_id,
                'tanggal_transaksi' => now(),
                'total_amount' => $total_amount,
                'total_diskon' => $total_diskon,
                'amount_paid' => $request->amount_paid,
                'kembalian' => $kembalian,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status' => 'completed',
                'catatan' => $request->catatan,
            ]);

            // Create transaction details and update stock
            foreach ($items as $item) {
                $produk = Produk::find($item['produk_id']);
                $subtotal = $produk->harga_dasar * $item['qty'];
                $diskon_item = ($subtotal * $diskon_persen) / 100;

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $item['produk_id'],
                    'qty' => $item['qty'],
                    'harga_satuan' => $produk->harga_dasar,
                    'diskon_persen' => $diskon_persen,
                    'diskon_amount' => $diskon_item,
                    'subtotal' => $subtotal - $diskon_item,
                ]);

                // Update product stock
                $produk->decrement('stok_sekarang', $item['qty']);
            }

            // Update pelanggan stats
            if ($request->pelanggan_id) {
                $pelanggan = Pelanggan::find($request->pelanggan_id);
                $pelanggan->increment('total_transaksi');
                $pelanggan->increment('total_belanja', $grand_total);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'transaksi' => $transaksi,
                'message' => 'Transaksi berhasil disimpan.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
        StokBarang::recordMovement(
            $item['produk_id'],
            'penjualan',
            $item['qty'],
            "Penjualan transaksi {$transaksi->kode_transaksi}",
            $transaksi->id
        );
    }

    public function riwayatTransaksi()
    {
        $transaksis = Transaksi::with(['user', 'pelanggan', 'detailTransaksis.produk'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('kasir.riwayat', compact('transaksis'));
    }

    public function showTransaksi(Transaksi $transaksi)
    {
        $transaksi->load(['user', 'pelanggan.golongan', 'detailTransaksis.produk']);
        return view('kasir.detail-transaksi', compact('transaksi'));
    }
}