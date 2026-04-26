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
        Schema::table('resikos', function (Blueprint $table) {
            $table->string('kode')->nullable();
            $table->text('pernyataan_risiko')->nullable();
            $table->text('why_1')->nullable();
            $table->text('why_2')->nullable();
            $table->text('why_3')->nullable();
            $table->text('why_4')->nullable();
            $table->text('why_5')->nullable();
            $table->text('akar_penyebab')->nullable();
            $table->string('kode_penyebab_jenis')->nullable();
            $table->integer('kode_penyebab_nomor')->nullable();
            $table->text('kegiatan_pengendalian')->nullable();
            $table->integer('tahun')->nullable();
            
            $table->string('name')->nullable()->change();
            $table->string('status')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resikos', function (Blueprint $table) {
            $table->dropColumn([
                'kode', 'pernyataan_risiko', 'why_1', 'why_2', 'why_3', 'why_4', 'why_5', 'akar_penyebab', 
                'kode_penyebab_jenis', 'kode_penyebab_nomor', 'kegiatan_pengendalian', 'tahun'
            ]);
        });
    }
};
