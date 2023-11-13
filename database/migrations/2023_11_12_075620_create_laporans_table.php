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
        Schema::create('laporan', function (Blueprint $table) {
            $table->bigIncrements('id_laporan');
            $table->foreignId("pembelian_id")->nullable()->constrained("pembelian", "id_pembelian")->onUpdate("cascade")->onDelete("no action");
            $table->foreignId("penjualan_id")->nullable()->constrained("penjualan", "id_penjualan")->onUpdate("cascade")->onDelete("no action");
            $table->string("kode_laporan")->unique();
            $table->string("nama_operasi");
            $table->date('tgl_laporan');
            $table->time('waktu');
            $table->integer('credit');
            $table->integer('debit');
            $table->integer('saldo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
