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
        // Schema::create('tb_pembelian', function (Blueprint $table) {
        //     $table->bigIncrements("id_pembelian");
        //     $table->date("tanggal_pembelian");
        //     $table->integer("total_harga_beli");
        //     $table->integer("total_harga_jual");
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};
