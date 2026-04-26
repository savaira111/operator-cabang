<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviu_usulan_risikos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resiko_id')->constrained('resikos')->cascadeOnDelete();
            $table->text('usulan_pernyataan_risiko');
            $table->string('unit_pemilik_pengusul');
            $table->enum('status', ['Diterima', 'Ditolak'])->default('Diterima');
            $table->text('alasan_diterima')->nullable();
            $table->text('alasan_ditolak')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviu_usulan_risikos');
    }
};
