<?php
// app/Models/Laporan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tipe_laporan',
        'judul_laporan',
        'tanggal_mulai',
        'tanggal_akhir',
        'filter',
        'format_export',
        'file_path',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_akhir' => 'date',
        'filter' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Generate report filename
    public function generateFilename()
    {
        $timestamp = now()->format('Ymd_His');
        return "laporan_{$this->tipe_laporan}_{$timestamp}.{$this->format_export}";
    }
}