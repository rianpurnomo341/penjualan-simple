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
        Schema::create('detail_pembelian', function (Blueprint $table) {
            $table->bigIncrements('id_detail_pembelian');
            $table->foreignId("barang_id")->nullable()->constrained("barang", "id_barang")->onUpdate("cascade")->onDelete("no action");
            $table->foreignId("pembelian_id")->nullable()->constrained("pembelian", "id_pembelian")->onUpdate("cascade")->onDelete("no action");
            $table->integer('qty');
            $table->integer('harga_pembelian');
            $table->integer('total_harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pembelian');
    }
};
