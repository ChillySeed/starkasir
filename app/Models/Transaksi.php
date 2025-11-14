<?php
// app/Models/Transaksi.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'user_id',
        'pelanggan_id',
        'tanggal_transaksi',
        'total_amount',
        'total_diskon',
        'amount_paid',
        'kembalian',
        'metode_pembayaran',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_transaksi' => 'datetime',
        'total_amount' => 'decimal:2',
        'total_diskon' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'kembalian' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    // Generate kode transaksi
    public static function generateKodeTransaksi()
    {
        $date = now()->format('Ymd');
        $lastTransaction = self::whereDate('created_at', today())->latest()->first();
        
        if ($lastTransaction) {
            $lastNumber = (int) substr($lastTransaction->kode_transaksi, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return 'TRX-' . $date . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}