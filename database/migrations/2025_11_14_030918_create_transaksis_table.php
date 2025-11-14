<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pelanggan_id')->nullable()->constrained('pelanggans')->onDelete('set null');
            $table->dateTime('tanggal_transaksi');
            $table->decimal('total_amount', 15, 2);
            $table->decimal('total_diskon', 15, 2)->default(0);
            $table->decimal('amount_paid', 15, 2);
            $table->decimal('kembalian', 15, 2)->default(0);
            $table->enum('metode_pembayaran', ['tunai', 'debit', 'kredit', 'qris'])->default('tunai');
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('completed');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
}