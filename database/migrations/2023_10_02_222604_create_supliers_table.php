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
        Schema::create('suplier', function (Blueprint $table) {
            $table->bigIncrements("id_suplier");
            $table->string("kode_suplier")->unique();
            $table->string("nama_suplier");
            $table->text("no_tlp");
            $table->string("alamat");
            $table->text("ket_suplier")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suplier');
    }
};
