<?php
// app/Models/StokBarang.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokBarang extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'qty_awal',
        'qty_keluar',
        'qty_masuk',
        'qty_akhir',
        'jenis_perubahan',
        'keterangan',
        'transaksi_id',
        'tanggal_perubahan',
    ];

    protected $casts = [
        'tanggal_perubahan' => 'datetime',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    // Get available types for stock movements
    public static function getJenisPerubahanOptions()
    {
        return [
            'pembelian' => 'Pembelian (Restock dari Supplier)',
            'adjustment_masuk' => 'Adjustment Stok Masuk (Koreksi)',
            'adjustment_keluar' => 'Adjustment Stok Keluar (Koreksi)',
            'retur' => 'Retur dari Pelanggan',
            'lainnya' => 'Lainnya (Hilang/Rusak)',
            'penjualan' => 'Penjualan',
        ];
    }

    // Get available types for filtering (just keys)
    public static function getJenisPerubahanKeys()
    {
        return array_keys(self::getJenisPerubahanOptions());
    }

    // Get label for jenis perubahan
    public function getJenisPerubahanLabelAttribute()
    {
        $options = self::getJenisPerubahanOptions();
        return $options[$this->jenis_perubahan] ?? $this->jenis_perubahan;
    }

    // Record stock movement
    public static function recordMovement($produkId, $jenisPerubahan, $qty, $keterangan = null, $transaksiId = null)
    {
        $produk = Produk::find($produkId);
        if (!$produk) return null;
        
        $stokAwal = $produk->stok_sekarang;
        
        switch ($jenisPerubahan) {
            case 'penjualan':
                $qtyKeluar = $qty;
                $qtyMasuk = 0;
                break;
            case 'pembelian':
                $qtyKeluar = 0;
                $qtyMasuk = $qty;
                break;
            case 'adjustment_masuk':
                $qtyKeluar = 0;
                $qtyMasuk = $qty;
                break;
            case 'adjustment_keluar':
                $qtyKeluar = $qty;
                $qtyMasuk = 0;
                break;
            case 'retur':
                $qtyKeluar = 0;
                $qtyMasuk = $qty;
                break;
            case 'lainnya':
                $qtyKeluar = $qty;
                $qtyMasuk = 0;
                break;
            default:
                $qtyKeluar = 0;
                $qtyMasuk = 0;
        }

        $stokAkhir = $stokAwal - $qtyKeluar + $qtyMasuk;

        $stokBarang = self::create([
            'produk_id' => $produkId,
            'qty_awal' => $stokAwal,
            'qty_keluar' => $qtyKeluar,
            'qty_masuk' => $qtyMasuk,
            'qty_akhir' => $stokAkhir,
            'jenis_perubahan' => $jenisPerubahan,
            'keterangan' => $keterangan,
            'transaksi_id' => $transaksiId,
            'tanggal_perubahan' => now(),
        ]);

        // Update product stock
        $produk->update([
            'stok_sekarang' => $stokAkhir,
        ]);

        return $stokBarang;
    }
}