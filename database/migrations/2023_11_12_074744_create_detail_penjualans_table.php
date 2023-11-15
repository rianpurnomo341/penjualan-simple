<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->bigIncrements('id_detail_penjualan');
            $table->foreignId("barang_id")->nullable()->constrained("barang", "id_barang")->onUpdate("cascade")->onDelete("no action");
            $table->foreignId("penjualan_id")->nullable()->constrained("penjualan", "id_penjualan")->onUpdate("cascade")->onDelete("no action");
            $table->integer('qty');
            $table->integer('harga_penjualan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penjualan');
    }
};
