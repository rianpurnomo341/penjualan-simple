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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->bigIncrements("id_penjualan");
            $table->string("kode_penjualan");
            $table->date("tanggal_penjualan");
            $table->integer("total_penjualan");
            $table->integer("jml_bayar_penjualan");
            $table->integer("jml_kembalian_penjualan");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
