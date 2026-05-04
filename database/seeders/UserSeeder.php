<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cabang = \App\Models\Cabang::first();
        
        // Update to Operator Kanwil (Previously Admin)
        \App\Models\User::updateOrCreate(
            ['username' => 'admin'],
            ['name' => 'Administrator', 'role' => 'operator kanwil', 'email' => 'admin@example.com', 'password' => bcrypt('Sipinter@2026')]
        );

        // Operator Kanwil
        \App\Models\User::updateOrCreate(
            ['username' => 'kanwil'],
            ['name' => 'Staff Kanwil', 'role' => 'operator kanwil', 'email' => 'staff@example.com', 'password' => bcrypt('Sipinter@2026')]
        );

        // Operator Cabang
        \App\Models\User::updateOrCreate(
            ['username' => 'cabang'],
            ['name' => 'Operator Cabang', 'role' => 'operator cabang', 'cabang_id' => $cabang->id ?? null, 'email' => 'manager@example.com', 'password' => bcrypt('Sipinter@2026')]
        );

        // Operator Cabang Banceuy
        $cabangBanceuy = \App\Models\Cabang::where('name', 'Lapas Kelas IIA Banceuy')->first();
        \App\Models\User::updateOrCreate(
            ['username' => 'Lapas kelas IIA Banceuy'],
            [
                'name' => 'Lapas kelas IIA Banceuy',
                'email' => 'lapas.banceuy@sipinter.id',
                'password' => bcrypt('Sipinter@2026'),
                'role' => 'operator cabang',
                'cabang_id' => $cabangBanceuy->id ?? null,
                'permissions' => [
                    'lpi_laporan_internal', 
                    'tahanan_management', 
                    'zi_input_data', 
                    'belanja_management'
                ]
            ]
        );
    }
}
