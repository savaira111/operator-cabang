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
        Schema::create('laporan_internal_excels', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id'); // 1-11
            $table->string('no_input')->nullable();
            $table->dateTime('tanggal_input')->nullable();
            $table->foreignId('cabang_id')->constrained('cabangs')->onDelete('cascade');
            $table->string('periode_bulan');
            $table->integer('periode_tahun');
            $table->text('keterangan')->nullable();
            $table->string('file_path')->nullable();
            $table->string('status_evaluasi')->nullable();
            $table->integer('prosentase')->nullable();
            $table->text('catatan_evaluasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_internal_excels');
    }
};
