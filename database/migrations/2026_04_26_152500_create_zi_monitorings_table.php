<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zi_monitorings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cabang_id')->constrained('cabangs')->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('zi_monitorings')->cascadeOnDelete();
            $table->string('tipe'); // SS1, SS2, K, RK
            $table->string('nomor'); // SS.1, K.2, RK.2.2
            $table->text('sasaran_kegiatan')->nullable();
            $table->string('indikator')->nullable();
            $table->string('target')->nullable();
            $table->text('outcome')->nullable();
            $table->text('rincian_kegiatan')->nullable();
            $table->string('indikator_output')->nullable();
            $table->string('target_output')->nullable();
            $table->string('waktu_pelaksanaan')->nullable(); // JSON or comma separated: B03,B06
            $table->string('anggaran')->nullable();
            $table->string('pelaksana')->nullable();
            $table->string('koordinator')->nullable();
            $table->string('data_dukung')->nullable(); // File path
            $table->string('status_data_dukung')->default('belum_ada'); // sesuai, menunggu, tidak_sesuai, belum_ada
            $table->integer('prosentase')->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zi_monitorings');
    }
};
