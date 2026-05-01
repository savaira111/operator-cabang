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
        Schema::table('identifikasi_risikos', function (Blueprint $table) {
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
        Schema::table('identifikasi_risikos', function (Blueprint $table) {
            $table->dropColumn(['status_evaluasi', 'prosentase', 'catatan_evaluasi']);
        });
    }
};
