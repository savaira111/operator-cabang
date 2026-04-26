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
        Schema::table('rencana_tindak_pengendalians', function (Blueprint $table) {
            $table->text('respons_risiko')->nullable();
            $table->string('klasifikasi_sub_unsur_spip')->nullable();
            $table->text('indikator_keluaran')->nullable();
            $table->string('frekuensi')->nullable();
            $table->string('dampak')->nullable();
            $table->string('level_risiko')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rencana_tindak_pengendalians', function (Blueprint $table) {
            $table->dropColumn([
                'respons_risiko',
                'klasifikasi_sub_unsur_spip',
                'indikator_keluaran',
                'frekuensi',
                'dampak',
                'level_risiko'
            ]);
        });
    }
};
