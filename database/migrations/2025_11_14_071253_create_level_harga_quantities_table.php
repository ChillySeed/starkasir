<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_level_harga_quantities_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelHargaQuantitiesTable extends Migration
{
    public function up()
    {
        Schema::create('level_harga_quantities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->integer('qty_min');
            $table->integer('qty_max')->nullable();
            $table->decimal('harga_khusus', 15, 2);
            $table->text('keterangan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['produk_id', 'qty_min']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('level_harga_quantities');
    }
}