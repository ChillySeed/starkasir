<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Tambahkan kolom status ke tabel transaksis jika belum ada
        if (Schema::hasTable('transaksis') && !Schema::hasColumn('transaksis', 'status')) {
            Schema::table('transaksis', function (Blueprint $table) {
                // Default 'lunas' agar data lama dianggap lunas
                $table->string('status')->default('lunas')->after('total_amount'); 
            });
        }

        // Tambahkan kolom status ke tabel pembelians jika belum ada
        if (Schema::hasTable('pembelians') && !Schema::hasColumn('pembelians', 'status')) {
            Schema::table('pembelians', function (Blueprint $table) {
                $table->string('status')->default('lunas')->after('total_biaya');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('transaksis')) {
            Schema::table('transaksis', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }

        if (Schema::hasTable('pembelians')) {
            Schema::table('pembelians', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};