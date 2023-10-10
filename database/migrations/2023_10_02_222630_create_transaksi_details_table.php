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
        Schema::create('tb_transaksi_detail', function (Blueprint $table) {
            $table->bigIncrements("id_transaksi_detail");
            $table->foreignId("id_transaksi")->nullable()->constrained("tb_transaksi", "id_transaksi")->onUpdate("cascade")->onDelete("no action");
            $table->foreignId("id_barang")->nullable()->constrained("tb_barang", "id_barang")->onUpdate("cascade")->onDelete("no action");
            $table->integer("kode_barang");
            $table->integer("nama_barang");
            $table->integer("satuan");
            $table->integer("qty");
            $table->integer("diskon");
            $table->integer("harga");
            $table->integer("total");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_details');
    }
};
