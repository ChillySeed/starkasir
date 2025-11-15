<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_laporans_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporansTable extends Migration
{
    public function up()
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('tipe_laporan'); // ['penjualan', 'pembelian', 'stok', 'keuangan']
            $table->string('judul_laporan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_akhir');
            $table->json('filter')->nullable();
            $table->string('format_export')->default('pdf'); // ['pdf', 'excel']
            $table->string('file_path')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporans');
    }
}