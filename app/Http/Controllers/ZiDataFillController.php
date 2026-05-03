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
        $branchId = auth()->user()->cabang_id;
        
        // Get all root monitorings that are either global OR belong to this specific branch
        $query = ZiMonitoring::with(['cabang', 'children'])
            ->whereNull('parent_id')
            ->where(function($q) use ($branchId) {
                $q->whereNull('cabang_id');
                if ($branchId) {
                    $q->orWhere('cabang_id', $branchId);
                }
            });

        $roots = $query->orderBy('nomor')->get();

        // If we have both a global template and a branch copy for the same nomor, prioritize the branch copy
        if ($branchId) {
            $monitorings = $roots->groupBy('nomor')->map(function($group) use ($branchId) {
                $branchVersion = $group->where('cabang_id', $branchId)->first();
                // ONLY return the branch version or the global one. NEVER another branch's version.
                return $branchVersion ?: $group->whereNull('cabang_id')->first();
            })->filter()->values();
        } else {
            $monitorings = $roots;
        }

        return view('zi_data_fill.index', compact('monitorings'));
    }

    public function edit($id)
    {
        $item = ZiMonitoring::with(['files', 'parent'])->findOrFail($id);
        $userBranchId = auth()->user()->cabang_id;
        
        // If the item belongs to another branch or is a global template, 
        // we must ensure the user has their own branch-specific copy.
        if ($userBranchId && $item->cabang_id !== $userBranchId) {
            $item = $this->ensureBranchCopy($item, $userBranchId);
        }
        
        // Periods available for this item
        $periods = $item->waktu_pelaksanaan ? explode(',', $item->waktu_pelaksanaan) : [];
        
        return view('zi_data_fill.edit', compact('item', 'periods'));
    }

    protected function ensureBranchCopy($item, $branchId)
    {
        // 1. Trace up to find the root (SS2) and clone the whole path if needed
        $path = [];
        $curr = $item;
        while($curr) {
            $path[] = $curr;
            $curr = $curr->parent;
        }
        $path = array_reverse($path); // SS2 -> K -> IO

        $parent_id = null;
        $branchCopy = null;

        foreach($path as $node) {
            // Check if this node (at this level) already exists for this branch
            $existing = ZiMonitoring::where('cabang_id', $branchId)
                ->where('nomor', $node->nomor)
                ->where('tipe', $node->tipe)
                ->where('parent_id', $parent_id)
                ->first();

            if (!$existing) {
                $new = $node->replicate();
                $new->cabang_id = $branchId;
                $new->parent_id = $parent_id;
                // Reset progress for new branch copy
                $new->prosentase = 0;
                $new->status_data_dukung = 'belum_ada';
                $new->catatan = null;
                $new->save();
                $existing = $new;
            }
            
            $parent_id = $existing->id;
            if ($node->id == $item->id) {
                $branchCopy = $existing;
            }
        }

        return $branchCopy->load(['files', 'parent']);
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
