<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksTable extends Migration
{
    public function up()
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('kode_produk')->unique();
            $table->string('nama_produk');
            $table->enum('satuan', ['pcs', 'botol', 'kemasan', 'kg', 'gram'])->default('pcs');
            $table->decimal('harga_dasar', 15, 2);
            $table->integer('stok_awal')->default(0);
            $table->integer('stok_sekarang')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('gambar')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produks');
    }
}