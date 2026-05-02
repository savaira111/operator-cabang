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
            $tahananQuery = Tahanan::where('cabang_id', $cabang->id)
                ->where('periode_tahun', $selectedTahun)
                ->when($selectedPeriode && $selectedPeriode !== 'all', fn($q) => $q->where('periode_bulan', $selectedPeriode));
            
            $tahananExists = $tahananQuery->exists();
            $tahananInputPct = $tahananExists ? 100 : 0;
            $tahananEvalPct = $tahananExists ? round($tahananQuery->avg('prosentase')) : 0;

            // 4. Penyerapan Anggaran (Belanja Satker) Logic
            $belanjaQuery = BelanjaSatker::where('cabang_id', $cabang->id)
                ->where('tahun', $selectedTahun)
                ->when($selectedPeriode && $selectedPeriode !== 'all', fn($q) => $q->where('bulan', $selectedPeriode));
                
            $belanjaExists = $belanjaQuery->exists();
            $belanjaInputPct = $belanjaExists ? 100 : 0;
            $belanjaEvalPct = $belanjaExists ? round($belanjaQuery->avg('prosentase')) : 0;

            // 5. LPI Tambahan Logic
            $lpiTambahQuery = \App\Models\LaporanPengendalian::where('cabang_id', $cabang->id)
                ->where('periode_tahun', $selectedTahun)
                ->when($selectedPeriode && $selectedPeriode !== 'all', fn($q) => $q->where('periode_bulan', $selectedPeriode));
                
            $lpiTambahExists = $lpiTambahQuery->exists();
            $lpiTambahInputPct = $lpiTambahExists ? 100 : 0;
            $lpiTambahEvalPct = $lpiTambahExists ? round($lpiTambahQuery->avg('prosentase')) : 0;

            $tahananCatatans = Tahanan::where('cabang_id', $cabang->id)
                ->where('periode_tahun', $selectedTahun)
                ->when($selectedPeriode && $selectedPeriode !== 'all', fn($q) => $q->where('periode_bulan', $selectedPeriode))
                ->whereNotNull('catatan_evaluasi')
                ->where('catatan_evaluasi', '!=', '')
                ->pluck('catatan_evaluasi')
                ->unique()
                ->values()
                ->map(fn($item, $key) => ($key + 1) . ". " . $item)
                ->implode("\n");
            
            $tahananCatatanFinal = $tahananCatatans ?: '-';

            $ziCurrentInput = $ziWithFiles;
            $ziCurrentEval = $ziVerified;
            $ziModuleTotal = $ziTotal > 0 ? $ziTotal : 26;

            $lpiCurrentInput = $lpiCompleted;
            $lpiCurrentEval = EvaluasiRisiko::whereHas('resiko', fn($q) => $q->where('cabang_id', $cabang->id)->where('tahun', $selectedTahun))->exists() ? 11 : 0;
            $lpiModuleTotal = 11;

            $periodTotal = ($selectedPeriode && $selectedPeriode !== 'all') ? 1 : 4;
            
            $tahananCurrentInput = $tahananQuery->count();
            $tahananCurrentEval = (int)round(($tahananQuery->sum('prosentase') / 100));
            
            $belanjaCurrentInput = $belanjaQuery->count();
            $belanjaCurrentEval = (int)round(($belanjaQuery->sum('prosentase') / 100));

            $lpiTambahCurrentInput = $lpiTambahQuery->count();
            $lpiTambahCurrentEval = (int)round(($lpiTambahQuery->sum('prosentase') / 100));

            $reportData[] = [
                'cabang' => $cabang->name,
                'periode' => $selectedPeriode ?? 'All',
                'tahun' => $selectedTahun,
                'catatan' => $tahananCatatanFinal,
                'modules' => [
                    'Zona Integritas' => [
                        'current_input' => $ziCurrentInput,
                        'current_eval' => $ziCurrentEval,
                        'total' => $ziModuleTotal,
                        'pct_input' => (int)$ziInputPct,
                        'pct_eval' => (int)$ziEvalPct,
                        'catatan' => '-'
                    ],
                    'Manajemen Resiko' => [
                        'current_input' => $lpiCurrentInput,
                        'current_eval' => $lpiCurrentEval,
                        'total' => $lpiModuleTotal,
                        'pct_input' => (int)$lpiInputPct,
                        'pct_eval' => (int)$lpiEvalPct,
                        'catatan' => '-'
                    ],
                    'Data Tahanan' => [
                        'current_input' => $tahananCurrentInput,
                        'current_eval' => $tahananCurrentEval,
                        'total' => $periodTotal,
                        'pct_input' => (int)$tahananInputPct,
                        'pct_eval' => (int)$tahananEvalPct,
                        'catatan' => $tahananCatatanFinal
                    ],
                    'Penyerapan Anggaran' => [
                        'current_input' => $belanjaCurrentInput,
                        'current_eval' => $belanjaCurrentEval,
                        'total' => $periodTotal,
                        'pct_input' => (int)$belanjaInputPct,
                        'pct_eval' => (int)$belanjaEvalPct,
                        'catatan' => '-'
                    ],
                    'LPI Tambahan' => [
                        'current_input' => $lpiTambahCurrentInput,
                        'current_eval' => $lpiTambahCurrentEval,
                        'total' => $periodTotal,
                        'pct_input' => (int)$lpiTambahInputPct,
                        'pct_eval' => (int)$lpiTambahEvalPct,
                        'catatan' => '-'
                    ],
                ]
            ];
        }

        return view('laporan.index', compact('cabangs', 'reportData', 'selectedCabang', 'selectedPeriode', 'selectedTahun', 'selectedJenis'));
    }
}
