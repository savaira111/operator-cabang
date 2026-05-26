<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $cabangId = $user->cabang_id;
        $tahun = $request->get('tahun', date('Y'));

        // Restored Base counts
        $tahananCount = \App\Models\Tahanan::when($cabangId, fn($q) => $q->where('cabang_id', $cabangId))->count();
        $ziCount = \App\Models\ZiMonitoring::where('tipe', 'IO')
            ->where('tahun', $tahun)
            ->when($cabangId, fn($q) => $q->where('cabang_id', $cabangId))
            ->count();
        $anggaranEvaluatedTotal = \App\Models\BelanjaSatker::when($cabangId, fn($q) => $q->where('cabang_id', $cabangId))
            ->where('status_evaluasi', 'sesuai')
            ->sum('total');

        // New LPI Statistics
        $totalLpiCount = \App\Models\IdentifikasiRisiko::when($cabangId, fn($q) => $q->where('cabang_id', $cabangId))->count();
        $lpiApprovedCount = \App\Models\IdentifikasiRisiko::when($cabangId, fn($q) => $q->where('cabang_id', $cabangId))
            ->where('status_evaluasi', 'sesuai')
            ->count();

        // Progress comparison for B03, B06, B09, B12
        $periods = [
            'B03' => ['Januari', 'Februari', 'Maret'],
            'B06' => ['April', 'Mei', 'Juni'],
            'B09' => ['Juli', 'Agustus', 'September'],
            'B12' => ['Oktober', 'November', 'Desember']
        ];
        
        $chartData = [];
        foreach ($periods as $periodKey => $months) {
            // ZI Progress
            $ziAvg = \App\Models\ZiMonitoring::where('tipe', 'IO')
                ->where('tahun', $tahun)
                ->where('waktu_pelaksanaan', 'like', '%' . $periodKey . '%')
                ->when($cabangId, fn($q) => $q->where('cabang_id', $cabangId))
                ->avg('prosentase') ?? 0;

            // LPI Progress
            $lpiAvg = \App\Models\IdentifikasiRisiko::when($cabangId, fn($q) => $q->where('cabang_id', $cabangId))
                ->where('tahun', $tahun)
                ->whereIn('bulan', $months)
                ->avg('prosentase') ?? 0;

            $chartData[$periodKey] = [
                'zi' => round($ziAvg),
                'lpi' => round($lpiAvg)
            ];
        }

        return view('dashboard', compact(
            'tahananCount', 
            'ziCount', 
            'anggaranEvaluatedTotal',
            'totalLpiCount',
            'lpiApprovedCount',
            'chartData',
            'tahun'
        ));
    }
}
