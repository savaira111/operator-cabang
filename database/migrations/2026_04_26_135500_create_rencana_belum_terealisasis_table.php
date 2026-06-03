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

            $table->unsignedBigInteger('rencana_tindak_pengendalian_id');
            $table->foreign(
                'rencana_tindak_pengendalian_id',
                'rbt_rtp_fk'
            )->references('id')
             ->on('rencana_tindak_pengendalians')
             ->onDelete('cascade');

            $table->text('keterangan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rencana_belum_terealisasis');
    }
};