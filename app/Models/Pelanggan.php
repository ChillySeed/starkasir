<?php
// app/Models/Pelanggan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_pelanggan',
        'nama',
        'golongan_id',
        'no_telp',
        'alamat',
        'total_transaksi',
        'total_belanja',
    ];

    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function getDiskonPersenAttribute()
    {
        return $this->golongan ? $this->golongan->diskon_persen : 0;
    }
}