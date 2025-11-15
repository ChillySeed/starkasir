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

    // Add new relationships
    public function levelHargaQuantities()
    {
        return $this->hasMany(LevelHargaQuantity::class);
    }

    public function levelHargaGolongans()
    {
        return $this->hasMany(LevelHargaGolongan::class);
    }

    public function stokBarangs()
    {
        return $this->hasMany(StokBarang::class);
    }

    // Accessor for gambar URL
    public function getGambarUrlAttribute()
    {
        if ($this->gambar) {
            $path = public_path('storage/produks/' . $this->gambar);

            if (file_exists($path)) {
                 return asset('storage/produks/' . $this->gambar);
            }
        }
        return asset('storage/produks/default-product.png');
    }

    public function getStokTersediaAttribute()
    {
        return $this->stok_sekarang;
    }

    // Get special price based on quantity
    public function getHargaBerdasarkanQuantity($quantity)
    {
        $levelHarga = $this->levelHargaQuantities()
            ->where('is_active', true)
            ->where('qty_min', '<=', $quantity)
            ->where(function($query) use ($quantity) {
                $query->where('qty_max', '>=', $quantity)
                      ->orWhereNull('qty_max');
            })
            ->orderBy('qty_min', 'desc')
            ->first();

        return $levelHarga ? $levelHarga->harga_khusus : $this->harga_dasar;
    }

    // Get special price based on golongan
    public function getHargaBerdasarkanGolongan($golonganId)
    {
        $levelHarga = $this->levelHargaGolongans()
            ->where('is_active', true)
            ->where('golongan_id', $golonganId)
            ->first();

        return $levelHarga ? $levelHarga->harga_khusus : $this->harga_dasar;
    }
}

    