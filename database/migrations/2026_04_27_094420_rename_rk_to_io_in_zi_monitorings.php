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
        DB::table('zi_monitorings')->where('tipe', 'RK')->update(['tipe' => 'IO']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('zi_monitorings')->where('tipe', 'IO')->update(['tipe' => 'RK']);
    }
};
