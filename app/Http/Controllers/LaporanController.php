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
            // General Period Target
            $periodTarget = ($selectedPeriode && $selectedPeriode !== 'all') ? 1 : 4;

            // 1. Zona Integritas Logic
            $ziMonitorings = ZiMonitoring::withCount('files')
                ->where('cabang_id', $cabang->id)
                ->where('tipe', 'IO')
                ->get();
            $ziTotal = 26; // Fixed target for indicators
            $ziWithFiles = $ziMonitorings->filter(function($m) { 
                return $m->files_count > 0 || $m->status_data_dukung != null; 
            })->count();
            $ziVerified = $ziMonitorings->where('status_data_dukung', 'sesuai')->count();
            
            // Presentase Data Masuk ZI
            $ziCurrentInput = $ziWithFiles;
            $ziInputDenominator = $periodTarget;
            $ziInputPct = $ziInputDenominator > 0 ? round(($ziCurrentInput / $ziInputDenominator) * 100) : 0;
            if ($ziInputPct > 100) $ziInputPct = 100;

            // Progress Evaluasi ZI
            $ziCurrentEval = $ziVerified;
            $ziEvalDenominator = $periodTarget;
            $ziEvalPct = $ziEvalDenominator > 0 ? round(($ziCurrentEval / $ziEvalDenominator) * 100) : 0;
            if ($ziEvalPct > 100) $ziEvalPct = 100;

            // 2. Manajemen Resiko (LPI) Logic
            // Correct filtering logic for all 11 LPI modules
            $idRisikoFilter = fn($q) => $q->where('cabang_id', $cabang->id)->whereYear('created_at', $selectedTahun);
            $resikoFilter = fn($q) => $q->where('cabang_id', $cabang->id)->where('tahun', $selectedTahun);

            $lpiCounts = [
                'identifikasi' => IdentifikasiRisiko::where($idRisikoFilter)->count(),
                'analisis' => AnalisisRisiko::whereHas('identifikasiRisiko', $idRisikoFilter)->count(),
                'prioritas' => AnalisisRisiko::whereHas('identifikasiRisiko', $idRisikoFilter)->count(),
                'akar' => Resiko::where($resikoFilter)->count(),
                'rencana' => RencanaTindakPengendalian::whereHas('resiko', $resikoFilter)->count(),
                'pem_kegiatan' => PemantauanKegiatan::whereHas('rencanaTindak.resiko', $resikoFilter)->count(),
                'pem_peristiwa' => PemantauanPeristiwa::whereHas('pemantauanKegiatan.rencanaTindak.resiko', $resikoFilter)->count(),
                'pem_level' => PemantauanLevelRisiko::whereHas('analisisRisiko.identifikasiRisiko', $idRisikoFilter)->count(),
                'reviu' => ReviuUsulanRisiko::whereHas('resiko', $resikoFilter)->count(),
                'belum_realisasi' => RencanaBelumTerealisasi::whereHas('rencanaTindakPengendalian.resiko', $resikoFilter)->count(),
                'evaluasi' => EvaluasiRisiko::whereHas('resiko', $resikoFilter)->count(),
            ];
            
            $lpiTotalActual = array_sum($lpiCounts);
            $riskCount = $lpiCounts['identifikasi'];
            
            $lpiCurrentInput = $lpiTotalActual;
            $lpiInputDenominator = $periodTarget;
            $lpiInputPct = $lpiInputDenominator > 0 ? round(($lpiCurrentInput / $lpiInputDenominator) * 100) : 0;
            if ($lpiInputPct > 100) $lpiInputPct = 100;

            $lpiCurrentEvalRisks = IdentifikasiRisiko::where($idRisikoFilter)->where('status_evaluasi', 'sesuai')->count();
            $lpiEvalDenominator = $periodTarget;
            // Scale evaluation progress: if all risks are Acc'd, then all records are Acc'd
            $lpiCurrentEval = ($riskCount > 0) ? round(($lpiCurrentEvalRisks / $riskCount) * $lpiEvalDenominator) : 0;
            $lpiEvalPct = $lpiEvalDenominator > 0 ? round(($lpiCurrentEval / $lpiEvalDenominator) * 100) : 0;
            if ($lpiEvalPct > 100) $lpiEvalPct = 100;

            // 3. Data Tahanan Logic
            $tahananTarget = ($selectedPeriode && $selectedPeriode !== 'all') ? 3 : 12;
            
            $tahananMonths = [];
            if ($selectedPeriode === 'B03') $tahananMonths = ['Januari', 'Februari', 'Maret'];
            elseif ($selectedPeriode === 'B06') $tahananMonths = ['April', 'Mei', 'Juni'];
            elseif ($selectedPeriode === 'B09') $tahananMonths = ['Juli', 'Agustus', 'September'];
            elseif ($selectedPeriode === 'B12') $tahananMonths = ['Oktober', 'November', 'Desember'];

            $tahananQuery = Tahanan::where('cabang_id', $cabang->id)
                ->where('periode_tahun', $selectedTahun);
                
            if ($selectedPeriode && $selectedPeriode !== 'all') {
                if (!empty($tahananMonths)) {
                    $tahananQuery->whereIn('periode_bulan', $tahananMonths);
                } else {
                    $tahananQuery->where('periode_bulan', $selectedPeriode);
                }
            }
            
            $tahananRecords = $tahananQuery->get();
            $tahananCurrentInput = $tahananRecords->count();
            $tahananInputDenominator = $tahananTarget;
            $tahananInputPct = $tahananInputDenominator > 0 ? round(($tahananCurrentInput / $tahananInputDenominator) * 100) : 0;
            if ($tahananInputPct > 100) $tahananInputPct = 100;

            // Count how many records have been evaluated
            $tahananCurrentEval = $tahananRecords->whereNotNull('status_evaluasi')
                                                 ->where('status_evaluasi', '!=', 'belum_dievaluasi')
                                                 ->count();
            // Using the same fixed denominator for evaluation progress
            $tahananEvalDenominator = $tahananTarget;
            // The percentage remains based on the score (prosentase)
            $tahananEvalPct = $tahananEvalDenominator > 0 ? round(($tahananRecords->sum('prosentase')) / $tahananEvalDenominator) : 0;
            if ($tahananEvalPct > 100) $tahananEvalPct = 100;

            // 4. Penyerapan Anggaran (Belanja Satker) Logic
            $belanjaQuery = BelanjaSatker::where('cabang_id', $cabang->id)
                ->where('tahun', $selectedTahun)
                ->when($selectedPeriode && $selectedPeriode !== 'all', fn($q) => $q->where('bulan', $selectedPeriode));
                
            $belanjaRecords = $belanjaQuery->get();
            $belanjaCurrentInput = $belanjaRecords->count();
            $belanjaInputDenominator = $periodTarget;
            $belanjaInputPct = $belanjaInputDenominator > 0 ? round(($belanjaCurrentInput / $belanjaInputDenominator) * 100) : 0;
            if ($belanjaInputPct > 100) $belanjaInputPct = 100;

            $belanjaCurrentEval = $belanjaRecords->whereNotNull('status_evaluasi')->where('status_evaluasi', '!=', 'belum_dievaluasi')->count();
            $belanjaEvalDenominator = $periodTarget;
            $belanjaEvalPct = $belanjaEvalDenominator > 0 ? round(($belanjaRecords->sum('prosentase')) / $belanjaEvalDenominator) : 0;
            if ($belanjaEvalPct > 100) $belanjaEvalPct = 100;

            // 5. LPI Tambahan Logic
            $lpiTambahQuery = \App\Models\LaporanPengendalian::where('cabang_id', $cabang->id)
                ->where('periode_tahun', $selectedTahun)
                ->when($selectedPeriode && $selectedPeriode !== 'all', fn($q) => $q->where('periode_bulan', $selectedPeriode));
                
            $lpiTambahRecords = $lpiTambahQuery->get();
            $lpiTambahCurrentInput = $lpiTambahRecords->count();
            $lpiTambahInputDenominator = $periodTarget;
            $lpiTambahInputPct = $lpiTambahInputDenominator > 0 ? round(($lpiTambahCurrentInput / $lpiTambahInputDenominator) * 100) : 0;
            if ($lpiTambahInputPct > 100) $lpiTambahInputPct = 100;

            $lpiTambahCurrentEval = $lpiTambahRecords->where('status_evaluasi', 'sesuai')->count();
            $lpiTambahEvalDenominator = $periodTarget;
            $lpiTambahEvalPct = $lpiTambahEvalDenominator > 0 ? round(($lpiTambahCurrentEval / $lpiTambahEvalDenominator) * 100) : 0;
            if ($lpiTambahEvalPct > 100) $lpiTambahEvalPct = 100;

            // Catatan Evaluasi (From Tahanan as standard)
            $tahananCatatans = $tahananRecords->whereNotNull('catatan_evaluasi')
                ->where('catatan_evaluasi', '!=', '')
                ->pluck('catatan_evaluasi')
                ->unique()
                ->values()
                ->map(fn($item, $key) => ($key + 1) . ". " . $item)
                ->implode("\n");
            
            $tahananCatatanFinal = $tahananCatatans ?: '-';

            $reportData[] = [
                'cabang' => $cabang->name,
                'periode' => $selectedPeriode ?? 'All',
                'tahun' => $selectedTahun,
                'catatan' => $tahananCatatanFinal,
                'modules' => [
                    'Zona Integritas' => [
                        'current_input' => $ziCurrentInput,
                        'current_eval' => $ziCurrentEval,
                        'total' => $ziInputDenominator,
                        'total_eval' => $ziEvalDenominator,
                        'pct_input' => (int)$ziInputPct,
                        'pct_eval' => (int)$ziEvalPct,
                        'catatan' => '-'
                    ],
                    'Manajemen Resiko' => [
                        'current_input' => $lpiCurrentInput,
                        'current_eval' => $lpiCurrentEval,
                        'total' => $lpiInputDenominator,
                        'total_eval' => $lpiEvalDenominator,
                        'pct_input' => (int)$lpiInputPct,
                        'pct_eval' => (int)$lpiEvalPct,
                        'catatan' => '-'
                    ],
                    'Data Tahanan' => [
                        'current_input' => $tahananCurrentInput,
                        'current_eval' => $tahananCurrentEval,
                        'total' => $tahananInputDenominator,
                        'total_eval' => $tahananEvalDenominator,
                        'pct_input' => (int)$tahananInputPct,
                        'pct_eval' => (int)$tahananEvalPct,
                        'catatan' => $tahananCatatanFinal
                    ],
                    'Penyerapan Anggaran' => [
                        'current_input' => $belanjaCurrentInput,
                        'current_eval' => $belanjaCurrentEval,
                        'total' => $belanjaInputDenominator,
                        'total_eval' => $belanjaEvalDenominator,
                        'pct_input' => (int)$belanjaInputPct,
                        'pct_eval' => (int)$belanjaEvalPct,
                        'catatan' => '-'
                    ],
                    'LPI Tambahan' => [
                        'current_input' => $lpiTambahCurrentInput,
                        'current_eval' => $lpiTambahCurrentEval,
                        'total' => $lpiTambahInputDenominator,
                        'total_eval' => $lpiTambahEvalDenominator,
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
