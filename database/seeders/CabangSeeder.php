<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Cabang::create(['name' => 'Cabang Jakarta Pusat', 'location' => 'Jakarta Pusat', 'description' => 'Kantor utama pusat operasional']);
        \App\Models\Cabang::create(['name' => 'Cabang Bandung Town', 'location' => 'Bandung', 'description' => 'Pusat pengembangan logistik']);
        \App\Models\Cabang::create(['name' => 'Cabang Surabaya Center', 'location' => 'Surabaya', 'description' => 'Distribusi wilayah timur']);
    }
}
