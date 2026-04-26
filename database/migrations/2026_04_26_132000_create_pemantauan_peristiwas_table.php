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
        Schema::create('pemantauan_peristiwas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemantauan_kegiatan_id')->constrained('pemantauan_kegiatans')->cascadeOnDelete();
            $table->text('uraian_peristiwa');
            $table->string('waktu_kejadian');
            $table->string('tempat_kejadian');
            $table->integer('skor_dampak');
            $table->text('pemicu_peristiwa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemantauan_peristiwas');
    }
};
