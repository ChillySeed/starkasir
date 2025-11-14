<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGolongansTable extends Migration
{
    public function up()
    {
        Schema::create('golongans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tier');
            $table->decimal('diskon_persen', 5, 2)->default(0);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('golongans');
    }
}