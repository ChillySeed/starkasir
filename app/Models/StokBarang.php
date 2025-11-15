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

    // Record stock movement
    public static function recordMovement($produkId, $jenisPerubahan, $qty, $keterangan = null, $transaksiId = null)
    {
        $produk = Produk::find($produkId);
        $stokAwal = $produk->stok_sekarang;
        
        switch ($jenisPerubahan) {
            case 'penjualan':
                $qtyKeluar = $qty;
                $qtyMasuk = 0;
                break;
            case 'pembelian':
            case 'adjustment':
                $qtyKeluar = 0;
                $qtyMasuk = $qty;
                break;
            case 'retur':
                $qtyKeluar = 0;
                $qtyMasuk = $qty;
                break;
            default:
                $qtyKeluar = 0;
                $qtyMasuk = 0;
        }

        $stokAkhir = $stokAwal - $qtyKeluar + $qtyMasuk;

        return self::create([
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
    }
}