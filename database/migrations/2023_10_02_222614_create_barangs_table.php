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
        Schema::create('barang', function (Blueprint $table) {
            $table->bigIncrements("id_barang");
            $table->text("display")->nullable();
            $table->string("kode_barang")->unique();
            $table->string("nama_barang");
            $table->foreignId("kategori_id")->nullable()->constrained("kategori", "id_kategori")->onUpdate("cascade")->onDelete("no action");
            $table->foreignId("satuan_id")->nullable()->constrained("satuan", "id_satuan")->onUpdate("cascade")->onDelete("no action");
            $table->integer('qty')->default(0);
            $table->integer("diskon")->nullable();
            $table->integer("harga_before_diskon");
            $table->integer("harga_after_diskon");
            $table->date("tgl_kadaluarsa");
            $table->text("deskripsi")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
