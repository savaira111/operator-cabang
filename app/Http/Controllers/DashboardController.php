<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $cabangId = $user->cabang_id;

        // Base counts with branch filter if applicable
        $userCount = \App\Models\User::when($cabangId, fn($q) => $q->where('cabang_id', $cabangId))->count();
        $cabangCount = \App\Models\Cabang::count(); // Usually for admin, but let's keep it for now
        
        $resikoCount = \App\Models\Resiko::when($cabangId, fn($q) => $q->where('cabang_id', $cabangId))->count();
        $tahananCount = \App\Models\Tahanan::when($cabangId, fn($q) => $q->where('cabang_id', $cabangId))->count();
        $ziCount = \App\Models\ZiMonitoring::where('tipe', 'IO')
            ->where(function($q) use ($cabangId) {
                $q->whereNull('cabang_id');
                if ($cabangId) {
                    $q->orWhere('cabang_id', $cabangId);
                }
            })->count();
        $anggaranTotal = \App\Models\BelanjaSatker::when($cabangId, fn($q) => $q->where('cabang_id', $cabangId))->sum('total');

        return view('dashboard', compact(
            'userCount', 
            'cabangCount', 
            'resikoCount', 
            'tahananCount', 
            'ziCount', 
            'anggaranTotal'
        ));
    }
}
