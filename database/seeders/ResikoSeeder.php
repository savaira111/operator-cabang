<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResikoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cabang = \App\Models\Cabang::first();
        \App\Models\Resiko::create(['name' => 'Data Leakage', 'status' => 'high', 'description' => 'Possible exposure of client data', 'cabang_id' => $cabang->id]);
        \App\Models\Resiko::create(['name' => 'Server Down', 'status' => 'medium', 'description' => 'Unplanned maintenance downtime', 'cabang_id' => $cabang->id]);
    }
}
