<?php

namespace App\Http\Controllers;

use App\Models\ZiMonitoring;
use App\Models\ZiMonitoringFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ZiDataFillController extends Controller
{
    public function index()
    {
        $monitorings = ZiMonitoring::with(['cabang', 'children'])
            ->whereNull('parent_id')
            ->orderBy('nomor')
            ->get();

        return view('zi_data_fill.index', compact('monitorings'));
    }

    public function edit($id)
    {
        $item = ZiMonitoring::with(['files', 'parent'])->findOrFail($id);
        
        // Periods available for this item
        $periods = $item->waktu_pelaksanaan ? explode(',', $item->waktu_pelaksanaan) : [];
        
        return view('zi_data_fill.edit', compact('item', 'periods'));
    }

    public function upload(Request $request, $id)
    {
        $request->validate([
            'period' => 'required|string',
            'file' => 'required|file|mimes:pdf|max:25600', // 25MB as per screenshot
        ]);

        $item = ZiMonitoring::findOrFail($id);
        
        // Find existing file for this period to delete if needed
        $existingFile = ZiMonitoringFile::where('zi_monitoring_id', $id)
            ->where('period', $request->period)
            ->first();

        if ($existingFile && $existingFile->file_path) {
            Storage::disk('public')->delete($existingFile->file_path);
        }

        $path = $request->file('file')->store('zi_monitoring_files', 'public');

        ZiMonitoringFile::updateOrCreate(
            ['zi_monitoring_id' => $id, 'period' => $request->period],
            ['file_path' => $path, 'status' => 'menunggu']
        );

        return back()->with('success', 'Data dukung untuk periode ' . $request->period . ' berhasil diunggah.');
    }
}
