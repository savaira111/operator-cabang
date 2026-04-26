<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluasi_risikos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resiko_id')->constrained('resikos')->cascadeOnDelete();
            $table->string('pemilik_risiko');
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluasi_risikos');
    }
};
