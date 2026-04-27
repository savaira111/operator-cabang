<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cabang;
use App\Models\Resiko;
use App\Models\Tahanan;
use App\Models\ZiMonitoring;
use App\Models\BelanjaSatker;
use App\Models\IdentifikasiRisiko;
use App\Models\AnalisisRisiko;
use App\Models\RencanaTindakPengendalian;
use App\Models\PemantauanKegiatan;
use App\Models\PemantauanPeristiwa;
use App\Models\PemantauanLevelRisiko;
use App\Models\ReviuUsulanRisiko;
use App\Models\RencanaBelumTerealisasi;
use App\Models\EvaluasiRisiko;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $cabangs = Cabang::all();
        $selectedCabang = $request->get('cabang_id');
        $selectedPeriode = $request->get('periode');
        $selectedTahun = $request->get('tahun', date('Y'));
        $selectedJenis = $request->get('jenis_laporan');

        $reportData = [];
        
        $query = Cabang::query();
        if ($selectedCabang && $selectedCabang !== 'all') {
            $query->where('id', $selectedCabang);
        }
        
        $filteredCabangs = $query->get();

        foreach ($filteredCabangs as $cabang) {
            // 1. Zona Integritas Logic
            $ziMonitorings = ZiMonitoring::withCount('files')
                ->where('cabang_id', $cabang->id)
                ->where('tipe', 'IO')
                ->get();
            $ziTotal = $ziMonitorings->count();
            $ziWithFiles = $ziMonitorings->filter(function($m) { 
                return $m->files_count > 0 || $m->status_data_dukung != null; 
            })->count();
            $ziVerified = $ziMonitorings->where('status_data_dukung', 'sesuai')->count();
            
            $ziInputPct = $ziTotal > 0 ? round(($ziWithFiles / $ziTotal) * 100) : 0;
            $ziEvalPct = $ziTotal > 0 ? round(($ziVerified / $ziTotal) * 100) : 0;

            // 2. Manajemen Resiko (LPI) Logic - Completion of 11 modules
            $lpiModulesCount = [
                IdentifikasiRisiko::where('cabang_id', $cabang->id)->whereYear('created_at', $selectedTahun)->exists(),
                AnalisisRisiko::where('cabang_id', $cabang->id)->whereYear('created_at', $selectedTahun)->exists(),
                AnalisisRisiko::where('cabang_id', $cabang->id)->whereYear('created_at', $selectedTahun)->where('is_priority', true)->exists(), // Prioritas
                Resiko::where('cabang_id', $cabang->id)->where('tahun', $selectedTahun)->exists(), // Akar Masalah
                RencanaTindakPengendalian::whereHas('resiko', fn($q) => $q->where('cabang_id', $cabang->id)->where('tahun', $selectedTahun))->exists(),
                PemantauanKegiatan::where('cabang_id', $cabang->id)->whereYear('created_at', $selectedTahun)->exists(),
                PemantauanPeristiwa::where('cabang_id', $cabang->id)->whereYear('created_at', $selectedTahun)->exists(),
                PemantauanLevelRisiko::where('cabang_id', $cabang->id)->whereYear('created_at', $selectedTahun)->exists(),
                ReviuUsulanRisiko::whereHas('resiko', fn($q) => $q->where('cabang_id', $cabang->id)->where('tahun', $selectedTahun))->exists(),
                RencanaBelumTerealisasi::where('cabang_id', $cabang->id)->whereYear('created_at', $selectedTahun)->exists(),
                EvaluasiRisiko::whereHas('resiko', fn($q) => $q->where('cabang_id', $cabang->id)->where('tahun', $selectedTahun))->exists(),
            ];
            
            $lpiCompleted = count(array_filter($lpiModulesCount));
            $lpiInputPct = round(($lpiCompleted / 11) * 100);
            $lpiEvalPct = EvaluasiRisiko::whereHas('resiko', fn($q) => $q->where('cabang_id', $cabang->id)->where('tahun', $selectedTahun))->exists() ? 100 : 0;

            // 3. Data Tahanan Logic
            $tahananExists = Tahanan::where('cabang_id', $cabang->id)
                ->where('periode_tahun', $selectedTahun)
                ->when($selectedPeriode && $selectedPeriode !== 'all', fn($q) => $q->where('periode_bulan', $selectedPeriode))
                ->exists();
            $tahananInputPct = $tahananExists ? 100 : 0;
            $tahananEvalPct = $tahananExists ? 100 : 0;

            // 4. Penyerapan Anggaran (Belanja Satker) Logic
            $belanjaExists = BelanjaSatker::where('cabang_id', $cabang->id)
                ->where('tahun', $selectedTahun)
                ->when($selectedPeriode && $selectedPeriode !== 'all', fn($q) => $q->where('bulan', $selectedPeriode))
                ->exists();
            $belanjaInputPct = $belanjaExists ? 100 : 0;
            $belanjaEvalPct = $belanjaExists ? 100 : 0;

            $reportData[] = [
                'cabang' => $cabang->name,
                'periode' => $selectedPeriode ?? 'All',
                'tahun' => $selectedTahun,
                'modules' => [
                    'Zona Integritas' => [
                        'input' => (int)$ziInputPct,
                        'evaluasi' => (int)$ziEvalPct
                    ],
                    'Manajemen Resiko' => [
                        'input' => (int)$lpiInputPct,
                        'evaluasi' => (int)$lpiEvalPct
                    ],
                    'Data Tahanan' => [
                        'input' => (int)$tahananInputPct,
                        'evaluasi' => (int)$tahananEvalPct
                    ],
                    'Penyerapan Anggaran' => [
                        'input' => (int)$belanjaInputPct,
                        'evaluasi' => (int)$belanjaEvalPct
                    ],
                ]
            ];
        }

        return view('laporan.index', compact('cabangs', 'reportData', 'selectedCabang', 'selectedPeriode', 'selectedTahun', 'selectedJenis'));
    }
}
