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
        Schema::create('zi_monitoring_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zi_monitoring_id')->constrained('zi_monitorings')->onDelete('cascade');
            $table->string('period'); // B03, B06, etc
            $table->string('file_path')->nullable();
            $table->string('status')->default('menunggu'); // sesuai, menunggu, tidak_sesuai
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zi_monitoring_files');
    }
};
