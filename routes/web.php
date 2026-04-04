<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\ResikoController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('users', UserController::class);
Route::resource('cabangs', CabangController::class);
Route::resource('resikos', ResikoController::class);

Route::get('/profile', function() {
    return view('profile');
})->name('profile');

Route::get('/logout', function() {
    // Logic logout normally goes here
    return redirect()->route('dashboard')->with('success', 'You have been logged out');
})->name('logout');
