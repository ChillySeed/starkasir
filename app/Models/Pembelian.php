<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Penting: Import Supplier agar relasi berfungsi
use App\Models\Supplier; 

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelians'; 

    protected $fillable = [
        'no_faktur',
        'supplier_id',
        'tanggal_pembelian',
        'total_biaya',
        'status',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_pembelian' => 'datetime',
        'total_biaya' => 'decimal:2',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class); 
    }
}