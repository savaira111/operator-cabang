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
        Schema::create('identifikasi_risikos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cabang_id')->constrained()->cascadeOnDelete();
            $table->string('jenis_konteks')->nullable();
            $table->string('nama_konteks')->nullable();
            $table->text('indikator')->nullable();
            $table->string('kode_risiko')->nullable();
            $table->text('pernyataan_risiko')->nullable();
            $table->string('kategori_risiko')->nullable();
            $table->text('uraian_dampak')->nullable();
            $table->text('metode_pencapaian_tujuan_spip')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identifikasi_risikos');
    }
};
