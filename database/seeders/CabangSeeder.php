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
        $wbbm = [
            'Lapas Kelas 1 cirebon',
            'Lapas Kelas IIA Cibinong',
        ];

        $wbk = [
            'Lapas kelas IIA Karawang',
            'Lapas Kelas IIA cikarang',
            'Lapas Narkotika Cirebon',
            'Lapas Kelas IIA Bogor',
            'Lapas Narkotika Kelas IIA Bandung',
            'Lapas Narkotika Kelas IIA Gunung Sindur',
            'Lapas Kelas IIA Banceuy',
            'Lapas Perempuan Kelas IIA bandung',
            'Lapas Kelas IIA Subang',
            'Lapas Kelas IIB Sumedang',
            'Lapas Kelas IIB Sukabumi',
            'Lapas Kelas IIB ciamis',
            'Lapas Kelas IIB Majalengka',
            'LPKA Kelas II bandung',
            'Rutan Kelas 1 Bandung',
            'Rutan Kelas 1 Cirebon',
            'Rutan Kelas 1 Depok',
            'Rutan Perempuan Bandung',
            'Rutan Kelas IIB Garut',
        ];

        $belumWbk = [
            'Lapas Kelas 1 Sukamiskin',
            'Lapas Kelas IIA Kuningan',
            'Lapas Kelas IIA Bekasi',
            'Lapas Kelas IIA Garut',
            'Lapas Kelas IIA Warung Kiara',
            'Lapas Kelas IIB Indramayu',
            'Lapas Kelas IIB Banjar',
            'Lapas Kelas IIB Cianjur',
            'Lapas Kelas IIB Purwakarta',
            'Lapas Khusus Kelas IIB Sentul',
            'Lapas Kelas IIB Tasik',
            'Lapas Khusus Kelas IIA Gunung Sindur',
            'Bapas Kelas I Bandung',
            'Bapas Kelas I Cirebon',
            'Bapas Kelas II Bekasi',
            'Bapas Kelas II Bogor',
            'Bapas Kelas II Garut',
            'Bapas kelas II Subang',
        ];

        $counter = 1;
        $generateKode = function() use (&$counter) {
            $kode = 'K' . str_pad($counter, 3, '0', STR_PAD_LEFT);
            $counter++;
            return $kode;
        };

        $getCity = function($name) {
            $removeWords = [
                'Lapas', 'Rutan', 'Bapas', 'LPKA', 
                'Khusus', 'Narkotika', 'Perempuan', 
                'Kelas 1', 'Kelas I', 'Kelas IIA', 'Kelas IIB', 'Kelas II',
                'kelas 1', 'kelas I', 'kelas IIA', 'kelas IIB', 'kelas II'
            ];
            $city = str_ireplace($removeWords, '', $name);
            return trim(ucwords(strtolower($city)));
        };

        foreach ($wbbm as $lapas) {
            \App\Models\Cabang::create([
                'kode_cabang' => $generateKode(),
                'name' => $lapas,
                'kepala_cabang' => 'sachan',
                'location' => 'Jawa Barat',
                'alamat' => $getCity($lapas),
                'description' => 'Sudah meraih WBBM',
            ]);
        }

        foreach ($wbk as $lapas) {
            \App\Models\Cabang::create([
                'kode_cabang' => $generateKode(),
                'name' => $lapas,
                'kepala_cabang' => 'sachan',
                'location' => 'Jawa Barat',
                'alamat' => $getCity($lapas),
                'description' => 'Sudah meraih WBK',
            ]);
        }

        foreach ($belumWbk as $lapas) {
            \App\Models\Cabang::create([
                'kode_cabang' => $generateKode(),
                'name' => $lapas,
                'kepala_cabang' => 'sachan',
                'location' => 'Jawa Barat',
                'alamat' => $getCity($lapas),
                'description' => 'Belum Meraih WBK',
            ]);
        }
    }
}
