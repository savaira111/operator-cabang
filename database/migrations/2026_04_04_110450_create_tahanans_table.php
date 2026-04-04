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
        Schema::create('tahanans', function (Blueprint $table) {
            $table->id();
            $table->string('no_input')->unique(); // Format: NoUrut/Bulan-Tahun/Id-Cabang
            $table->date('tanggal_input'); // Auto-system
            $table->foreignId('cabang_id')->constrained()->onDelete('cascade');
            $table->string('periode_bulan');
            $table->integer('periode_tahun');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahanans');
    }
};
