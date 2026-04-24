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
        Schema::create('zi_soals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zona_integritas_id')->constrained('zona_integritas')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('zi_soals')->onDelete('cascade');
            $table->string('tipe')->default('kategori'); // 'kategori' atau 'soal'
            $table->string('nomor')->nullable(); // e.g. A., I., 1., a.
            $table->text('judul')->nullable(); // Nama kategori atau indikator soal
            $table->decimal('bobot', 8, 2)->nullable();
            $table->decimal('nilai_standar', 8, 2)->nullable(); // Nilai max 1.00 dsb
            
            // Kolom untuk tipe 'soal'
            $table->text('kriteria_nilai')->nullable();
            $table->string('tipe_jawaban')->nullable(); // 'ya_tidak', 'a_b_c', 'a_b_c_d' dll
            $table->text('penjelasan_a')->nullable();
            $table->text('penjelasan_b')->nullable();
            $table->text('penjelasan_c')->nullable();
            $table->text('penjelasan_d')->nullable();
            
            $table->integer('kebutuhan_bukti_dukung')->default(1);
            $table->text('keterangan_bukti_dukung')->nullable();
            
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zi_soals');
    }
};
