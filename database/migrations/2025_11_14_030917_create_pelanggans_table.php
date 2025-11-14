<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelanggansTable extends Migration
{
    public function up()
    {
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pelanggan')->unique();
            $table->string('nama');
            $table->foreignId('golongan_id')->constrained('golongans')->onDelete('cascade');
            $table->string('no_telp')->nullable();
            $table->text('alamat')->nullable();
            $table->integer('total_transaksi')->default(0);
            $table->decimal('total_belanja', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelanggans');
    }
}