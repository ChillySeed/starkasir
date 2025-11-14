<?php
// app/Models/Produk.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'satuan',
        'harga_dasar',
        'stok_awal',
        'stok_sekarang',
        'is_active',
        'gambar',
        'deskripsi',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'harga_dasar' => 'decimal:2',
        'stok_awal' => 'integer',
        'stok_sekarang' => 'integer',
    ];

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    // Accessor for gambar URL
    public function getGambarUrlAttribute()
    {
        if ($this->gambar) {
            return asset('storage/produks/' . $this->gambar);
        }
        return asset('images/default-product.png');
    }

    public function getStokTersediaAttribute()
    {
        return $this->stok_sekarang;
    }
}