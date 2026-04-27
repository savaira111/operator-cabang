<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("UPDATE zi_monitorings SET nomor = REPLACE(nomor, 'RK.', 'IO.') WHERE tipe = 'IO'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("UPDATE zi_monitorings SET nomor = REPLACE(nomor, 'IO.', 'RK.') WHERE tipe = 'IO'");
    }
};
