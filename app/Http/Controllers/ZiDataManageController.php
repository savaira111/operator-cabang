<?php

namespace App\Http\Controllers;

use App\Models\ZiMonitoring;
use App\Models\ZiMonitoringFile;
use Illuminate\Http\Request;

class ZiDataManageController extends Controller
{
    public function index(Request $request)
    {
        $selectedPeriod = $request->get('period');
        $selectedYear = $request->get('tahun');

        if (!$selectedPeriod || !$selectedYear) {
            $monitorings = collect();
            return view('zi_data_manage.index', compact('monitorings', 'selectedPeriod', 'selectedYear'));
        }

        $query = ZiMonitoring::with([
                'cabang', 
                'children' => function($q) use ($selectedPeriod) {
                    $q->whereHas('children', function($q2) use ($selectedPeriod) {
                        $q2->where('waktu_pelaksanaan', 'LIKE', '%' . $selectedPeriod . '%');
                    });
                },
                'children.children' => function($q) use ($selectedPeriod) {
                    $q->where('waktu_pelaksanaan', 'LIKE', '%' . $selectedPeriod . '%');
                }
            ])
            ->whereNull('parent_id');

        if ($selectedYear) {
            $query->where('tahun', $selectedYear);
        }

        if ($selectedPeriod) {
            // Only show roots that have children OR grandchildren matching the period
            $query->where(function($q) use ($selectedPeriod) {
                $q->whereHas('children', function($q) use ($selectedPeriod) {
                    $q->where('waktu_pelaksanaan', 'LIKE', '%' . $selectedPeriod . '%')
                      ->orWhereHas('children', function($q) use ($selectedPeriod) {
                          $q->where('waktu_pelaksanaan', 'LIKE', '%' . $selectedPeriod . '%');
                      });
                });
            });
        }

        $monitorings = $query->orderBy('nomor')->get();

        return view('zi_data_manage.index', compact('monitorings', 'selectedPeriod', 'selectedYear'));
    }

    public function show($id)
    {
        $item = ZiMonitoring::with(['cabang', 'parent', 'files'])->findOrFail($id);
        return view('zi_data_manage.show', compact('item'));
    }

    public function updateFileStatus(Request $request, $fileId)
    {
        $file = ZiMonitoringFile::findOrFail($fileId);
        
        $status = $request->status;
        $catatan = $request->catatan;

        $file->update([
            'status' => $status,
            'catatan' => $catatan
        ]);

        // Optional: Update parent monitoring percentage based on overall files status
        $monitoring = $file->monitoring;
        $totalFiles = $monitoring->files->count();
        $sesuaiFiles = $monitoring->files->where('status', 'sesuai')->count();
        $menungguFiles = $monitoring->files->where('status', 'menunggu')->count();
        $tidakSesuaiFiles = $monitoring->files->where('status', 'tidak_sesuai')->count();

        // Calculate a simple percentage for the entire IO
        // Logic: (sesuai * 100 + menunggu * 75 + tidak_sesuai * 25) / total
        if ($totalFiles > 0) {
            $prosentase = (($sesuaiFiles * 100) + ($menungguFiles * 75) + ($tidakSesuaiFiles * 25)) / $totalFiles;
            $monitoring->update(['prosentase' => round($prosentase)]);
        }

        return back()->with('success', 'Status file ' . $file->period . ' berhasil diperbarui.');
    }
}
