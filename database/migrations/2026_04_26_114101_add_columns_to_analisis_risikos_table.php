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
        Schema::table('analisis_risikos', function (Blueprint $table) {
            // Renaming or keeping existing if they match logic
            // 3. Skor Probabilitas (Melekat) -> existing 'frekuensi'
            // 4. Skor Dampak (Melekat) -> existing 'dampak'
            // 5. Level Risiko (Melekat) -> existing 'level_risiko'
            
            // Pengendalian yang Ada
            $table->string('ada_belum_ada')->nullable(); // 6
            $table->text('uraian_pengendalian')->nullable(); // 7
            $table->string('memadai_belum_memadai')->nullable(); // 8
            
            // Skor/Nilai Risiko Residu
            $table->string('skor_probabilitas_residu')->nullable(); // 9
            $table->string('skor_dampak_residu')->nullable(); // 10
            $table->string('level_risiko_residu')->nullable(); // 11
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('analisis_risikos', function (Blueprint $table) {
            //
        });
    }
};
