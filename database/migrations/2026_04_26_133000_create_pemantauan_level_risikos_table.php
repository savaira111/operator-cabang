<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemantauan_level_risikos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('analisis_risiko_id')->constrained('analisis_risikos')->cascadeOnDelete();
            $table->text('deviasi')->nullable();
            $table->text('rekomendasi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemantauan_level_risikos');
    }
};
