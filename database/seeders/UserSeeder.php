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
        
        \App\Models\User::firstOrCreate(
            ['username' => 'admin'],
            ['name' => 'Admin Utama', 'role' => 'operator admin', 'email' => 'admin@example.com', 'password' => bcrypt('password')]
        );

        \App\Models\User::firstOrCreate(
            ['username' => 'kanwil'],
            ['name' => 'Staff Kanwil', 'role' => 'operator kanwil', 'email' => 'staff@example.com', 'password' => bcrypt('password')]
        );

        \App\Models\User::firstOrCreate(
            ['username' => 'cabang'],
            ['name' => 'Manager Cabang', 'role' => 'operator cabang', 'cabang_id' => $cabang->id ?? null, 'email' => 'manager@example.com', 'password' => bcrypt('password')]
        );
    }
}
