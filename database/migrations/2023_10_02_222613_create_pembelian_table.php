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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->bigIncrements("id_pembelian");
            $table->string("kode_pembelian");
            $table->foreignId("suplier_id")->nullable()->constrained("suplier", "id_suplier")->onUpdate("cascade")->onDelete("no action");
            $table->date("tanggal_pembelian");
            $table->integer("total_pembelian");
            $table->integer("jml_bayar_pembelian");
            $table->integer("jml_kembalian_pembelian");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};
