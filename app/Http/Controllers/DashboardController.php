<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = \App\Models\User::count();
        $cabangCount = \App\Models\Cabang::count();
        $resikoCount = \App\Models\Resiko::count();
        $tahananCount = \App\Models\Tahanan::count();

        return view('dashboard', compact('userCount', 'cabangCount', 'resikoCount', 'tahananCount'));
    }
}
