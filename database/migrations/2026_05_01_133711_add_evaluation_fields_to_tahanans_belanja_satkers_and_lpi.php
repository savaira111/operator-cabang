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
        Schema::table('tahanans', function (Blueprint $table) {
            $table->string('status_evaluasi')->default('belum_dievaluasi');
            $table->integer('prosentase')->default(0);
            $table->text('catatan_evaluasi')->nullable();
        });

        Schema::table('belanja_satkers', function (Blueprint $table) {
            $table->string('status_evaluasi')->default('belum_dievaluasi');
            $table->integer('prosentase')->default(0);
            $table->text('catatan_evaluasi')->nullable();
        });

        Schema::table('laporan_pengendalians', function (Blueprint $table) {
            $table->foreignId('cabang_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('nama_laporan')->nullable();
            $table->string('periode_bulan')->nullable();
            $table->integer('periode_tahun')->nullable();
            $table->string('file_path')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('status_evaluasi')->default('belum_dievaluasi');
            $table->integer('prosentase')->default(0);
            $table->text('catatan_evaluasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tahanans', function (Blueprint $table) {
            $table->dropColumn(['status_evaluasi', 'prosentase', 'catatan_evaluasi']);
        });

        Schema::table('belanja_satkers', function (Blueprint $table) {
            $table->dropColumn(['status_evaluasi', 'prosentase', 'catatan_evaluasi']);
        });

        Schema::table('laporan_pengendalians', function (Blueprint $table) {
            $table->dropForeign(['cabang_id']);
            $table->dropColumn([
                'cabang_id', 'nama_laporan', 'periode_bulan', 'periode_tahun', 
                'file_path', 'keterangan', 'status_evaluasi', 'prosentase', 'catatan_evaluasi'
            ]);
        });
    }
};
