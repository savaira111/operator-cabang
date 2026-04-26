<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rencana_belum_terealisasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rencana_tindak_pengendalian_id')->constrained('rencana_tindak_pengendalians')->cascadeOnDelete();
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rencana_belum_terealisasis');
    }
};
