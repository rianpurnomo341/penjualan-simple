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
        Schema::create('tb_barang', function (Blueprint $table) {
            $table->bigIncrements("id_barang");
            $table->foreignId("id_pembelian")->nullable()->constrained("tb_pembelian", "id_pembelian")->onUpdate("cascade")->onDelete("no action");
            $table->string("kode_barang");
            $table->text("display");
            $table->string("nama");
            $table->foreignId("id_kategori")->nullable()->constrained("tb_kategori", "id_kategori")->onUpdate("cascade")->onDelete("no action");
            $table->foreignId("id_satuan")->nullable()->constrained("tb_satuan", "id_satuan")->onUpdate("cascade")->onDelete("no action");
            $table->integer("diskon");
            $table->integer("harga");
            $table->text("promo");
            $table->text("deskripsi");
            $table->date("kadaluarsa");
            $table->foreignId("id_suplier")->nullable()->constrained("tb_suplier", "id_suplier")->onUpdate("cascade")->onDelete("no action");
            $table->integer("total_pembelian_unit");
            $table->integer("total_pembelian_rp");
            $table->integer("total_penjualan_unit");
            $table->integer("total_penjualan_rp");
            $table->integer("provit");
            $table->text("keterangan");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
