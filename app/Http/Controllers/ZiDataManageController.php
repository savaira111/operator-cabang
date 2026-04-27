<?php

namespace App\Http\Controllers;

use App\Models\ZiMonitoring;
use App\Models\ZiMonitoringFile;
use Illuminate\Http\Request;

class ZiDataManageController extends Controller
{
    public function index()
    {
        $monitorings = ZiMonitoring::with(['cabang', 'children'])
            ->whereNull('parent_id')
            ->orderBy('nomor')
            ->get();

        return view('zi_data_manage.index', compact('monitorings'));
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
