<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Buat Tabel Suppliers
        if (!Schema::hasTable('suppliers')) {
            Schema::create('suppliers', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->string('alamat')->nullable();
                $table->string('telepon')->nullable();
                $table->text('keterangan')->nullable();
                $table->timestamps();
            });
        }

        // 2. Buat Tabel Pembelians (Stok Masuk)
        if (!Schema::hasTable('pembelians')) {
            Schema::create('pembelians', function (Blueprint $table) {
                $table->id();
                $table->string('no_faktur')->nullable();
                
                // Relasi ke supplier (opsional, bisa null jika supplier dihapus)
                $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('set null');
                
                $table->dateTime('tanggal_pembelian');
                $table->decimal('total_biaya', 15, 2)->default(0);
                
                // Kolom status (saya tambahkan default 'lunas' agar aman)
                $table->string('status')->default('lunas'); 
                $table->text('keterangan')->nullable();
                
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('pembelians');
        Schema::dropIfExists('suppliers');
    }
};