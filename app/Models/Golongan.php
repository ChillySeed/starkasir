<?php
// app/Models/Golongan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Golongan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_tier',
        'diskon_persen',
        'deskripsi',
    ];

    public function pelanggans()
    {
        return $this->hasMany(Pelanggan::class);
    }
}