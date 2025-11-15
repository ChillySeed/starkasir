<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_stok_barangs_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStokBarangsTable extends Migration
{
    public function up()
    {
        Schema::create('stok_barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->integer('qty_awal');
            $table->integer('qty_keluar')->default(0);
            $table->integer('qty_masuk')->default(0);
            $table->integer('qty_akhir');
            $table->string('jenis_perubahan'); // ['penjualan', 'pembelian', 'adjustment', 'retur']
            $table->text('keterangan')->nullable();
            $table->foreignId('transaksi_id')->nullable()->constrained('transaksis')->onDelete('set null');
            $table->dateTime('tanggal_perubahan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stok_barangs');
    }
}