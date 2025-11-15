<?php
// app/Models/LevelHargaQuantity.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelHargaQuantity extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'qty_min',
        'qty_max',
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

    // Accessor for range description
    public function getRangeDescriptionAttribute()
    {
        if ($this->qty_max) {
            return "{$this->qty_min} - {$this->qty_max} pcs";
        } else {
            return "≥ {$this->qty_min} pcs";
        }
    }
}