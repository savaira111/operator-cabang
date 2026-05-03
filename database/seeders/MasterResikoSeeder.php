<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterRiskCode;
use App\Models\MasterCauseCode;

class MasterResikoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dummy data for Master Risk Codes
        $riskCodes = [
            ['kode' => 'WP', 'nama_risiko' => 'Wajib Pajak'],
            ['kode' => 'SEK', 'nama_risiko' => 'Sekretariat'],
            ['kode' => 'MIP', 'nama_risiko' => 'Manajemen Informasi Perpajakan'],
            ['kode' => 'UPT', 'nama_risiko' => 'Unit Pelaksana Teknis'],
        ];

        foreach ($riskCodes as $risk) {
            MasterRiskCode::updateOrCreate(['kode' => $risk['kode']], $risk);
        }

        // Dummy data for Master Cause Codes
        $causeCodes = [
            ['kode' => 'MN', 'nama_penyebab' => 'Orang (Man)'],
            ['kode' => 'MY', 'nama_penyebab' => 'Dana (Money)'],
            ['kode' => 'MD', 'nama_penyebab' => 'Metode (Method)'],
            ['kode' => 'MR', 'nama_penyebab' => 'Bahan (Material)'],
            ['kode' => 'MC', 'nama_penyebab' => 'Mesin (Machine)'],
            ['kode' => 'EX', 'nama_penyebab' => 'Eksternal'],
        ];

        foreach ($causeCodes as $cause) {
            MasterCauseCode::updateOrCreate(['kode' => $cause['kode']], $cause);
        }
    }
}
