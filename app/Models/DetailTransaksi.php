<?php
// app/Models/DetailTransaksi.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'qty',
        'harga_satuan',
        'diskon_persen',
        'diskon_amount',
        'subtotal',
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'diskon_persen' => 'decimal:2',
        'diskon_amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}