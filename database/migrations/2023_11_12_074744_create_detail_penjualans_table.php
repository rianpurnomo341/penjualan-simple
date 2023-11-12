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
            $table->foreignId("barang_id")->constrained("barang", "id_barang")->onUpdate("cascade")->onDelete("no action")->nullable();
            $table->foreignId("penjualan_id")->constrained("penjualan", "id_penjualan")->onUpdate("cascade")->onDelete("no action")->nullable();
            $table->integer('qty');
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
