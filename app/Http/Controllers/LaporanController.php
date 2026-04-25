<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cabang;
use App\Models\Resiko;
use App\Models\Tahanan;
use App\Models\Zi;
use App\Models\BelanjaSatker;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $cabangs = Cabang::all();
        $selectedCabang = $request->get('cabang_id');
        $selectedPeriode = $request->get('periode');
        $selectedTahun = $request->get('tahun', date('Y'));
        $selectedJenis = $request->get('jenis_laporan');

        // Sample data logic for the monitoring table
        $reportData = [];
        
        $query = Cabang::query();
        if ($selectedCabang && $selectedCabang !== 'all') {
            $query->where('id', $selectedCabang);
        }
        
        $filteredCabangs = $query->get();

        foreach ($filteredCabangs as $cabang) {
            // Mocking percentage data for demonstration
            // In a real app, you'd count records for each module per branch/period/year
            $reportData[] = [
                'cabang' => $cabang->name,
                'periode' => $selectedPeriode ?? 'All',
                'tahun' => $selectedTahun,
                'modules' => [
                    'Zona Integritas' => [
                        'input' => rand(50, 100),
                        'evaluasi' => rand(20, 80)
                    ],
                    'Manajemen Resiko' => [
                        'input' => rand(30, 100),
                        'evaluasi' => rand(10, 60)
                    ],
                    'Data Tahanan' => [
                        'input' => rand(70, 100),
                        'evaluasi' => rand(40, 90)
                    ],
                    'Belanja Satker' => [
                        'input' => rand(40, 100),
                        'evaluasi' => rand(15, 50)
                    ],
                ]
            ];
        }

        return view('laporan.index', compact('cabangs', 'reportData', 'selectedCabang', 'selectedPeriode', 'selectedTahun', 'selectedJenis'));
    }
}
