<?php
// app/Models/LevelHargaGolongan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelHargaGolongan extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'golongan_id',
        'harga_khusus',
        'keterangan',
        'is_active',
    ];

    protected $casts = [
        'harga_khusus' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }
}