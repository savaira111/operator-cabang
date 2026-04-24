<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\ResikoController;
use App\Http\Controllers\TahananController;
use App\Http\Controllers\ZiController;
use App\Http\Controllers\BelanjaSatkerController;

Route::get('/', function () {
    return view('welcome');
})->name('landing');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
use App\Http\Controllers\ZiSoalController;

Route::resource('users', UserController::class);
Route::resource('cabangs', CabangController::class);
Route::resource('resikos', ResikoController::class);
Route::resource('tahanans', TahananController::class);
Route::resource('zis', ZiController::class);
Route::resource('belanja-satker', BelanjaSatkerController::class);

Route::post('/zis/{zi}/soals', [ZiSoalController::class, 'store'])->name('zi_soals.store');
Route::put('/zi_soals/{soal}', [ZiSoalController::class, 'update'])->name('zi_soals.update');
Route::delete('/zi_soals/{soal}', [ZiSoalController::class, 'destroy'])->name('zi_soals.destroy');

Route::get('/profile', function() {
    return view('profile');
})->name('profile');

Route::get('/logout', function() {
    // Logic logout normally goes here
    return redirect()->route('dashboard')->with('success', 'Anda berhasil keluar dari sistem');
})->name('logout');
