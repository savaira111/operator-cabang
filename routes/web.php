<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\ResikoController;
use App\Http\Controllers\TahananController;
use App\Http\Controllers\ZiController;
use App\Http\Controllers\BelanjaSatkerController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return view('welcome');
})->name('landing');

use App\Http\Controllers\LoginController;
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [LoginController::class, 'showForgotPasswordForm'])->name('password.request');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
use App\Http\Controllers\ZiSoalController;

Route::resource('users', UserController::class);
Route::resource('cabangs', CabangController::class);
Route::resource('resikos', ResikoController::class);
Route::resource('rencana-tindak', \App\Http\Controllers\RencanaTindakPengendalianController::class);
Route::resource('pemantauan-kegiatan', \App\Http\Controllers\PemantauanKegiatanController::class);
Route::resource('pemantauan-peristiwa', \App\Http\Controllers\PemantauanPeristiwaController::class);
Route::resource('pemantauan-level', \App\Http\Controllers\PemantauanLevelRisikoController::class);
Route::resource('reviu-usulan', \App\Http\Controllers\ReviuUsulanRisikoController::class);
Route::resource('rencana-belum-terealisasi', \App\Http\Controllers\RencanaBelumTerealisasiController::class);
Route::resource('evaluasi-risiko', \App\Http\Controllers\EvaluasiRisikoController::class);
Route::resource('zi-monitoring', \App\Http\Controllers\ZiMonitoringController::class);
Route::get('zi-data-manage', [\App\Http\Controllers\ZiDataManageController::class, 'index'])->name('zi-data-manage.index');
Route::get('zi-data-manage/{id}', [\App\Http\Controllers\ZiDataManageController::class, 'show'])->name('zi-data-manage.show');
Route::post('zi-data-manage/file/{fileId}/status', [\App\Http\Controllers\ZiDataManageController::class, 'updateFileStatus'])->name('zi-data-manage.update-file-status');

Route::get('zi-data-fill', [\App\Http\Controllers\ZiDataFillController::class, 'index'])->name('zi-data-fill.index');
Route::get('zi-data-fill/{id}/edit', [\App\Http\Controllers\ZiDataFillController::class, 'edit'])->name('zi-data-fill.edit');
Route::post('zi-data-fill/{id}/upload', [\App\Http\Controllers\ZiDataFillController::class, 'upload'])->name('zi-data-fill.upload');

Route::resource('identifikasi-risiko', \App\Http\Controllers\IdentifikasiRisikoController::class);
Route::resource('analisis-risiko', \App\Http\Controllers\AnalisisRisikoController::class);
Route::get('daftar-prioritas', [\App\Http\Controllers\DaftarPrioritasController::class, 'index'])->name('daftar-prioritas.index');
Route::resource('tahanans', TahananController::class);
Route::resource('penilaian-tahanan', \App\Http\Controllers\PenilaianTahananController::class);
Route::resource('zis', ZiController::class);

Route::resource('belanja-satker', BelanjaSatkerController::class);
Route::resource('penilaian-belanja', \App\Http\Controllers\PenilaianBelanjaController::class);

Route::resource('laporan-pengendalian', \App\Http\Controllers\LaporanPengendalianController::class);
Route::resource('penilaian-lpi', \App\Http\Controllers\PenilaianLpiController::class);

Route::get('master-resiko', [\App\Http\Controllers\MasterResikoController::class, 'index'])->name('master-resiko.index');
Route::post('master-resiko/risk', [\App\Http\Controllers\MasterResikoController::class, 'storeRisk'])->name('master-resiko.store-risk');
Route::put('master-resiko/risk/{risk}', [\App\Http\Controllers\MasterResikoController::class, 'updateRisk'])->name('master-resiko.update-risk');
Route::delete('master-resiko/risk/{risk}', [\App\Http\Controllers\MasterResikoController::class, 'destroyRisk'])->name('master-resiko.destroy-risk');
Route::post('master-resiko/cause', [\App\Http\Controllers\MasterResikoController::class, 'storeCause'])->name('master-resiko.store-cause');
Route::put('master-resiko/cause/{cause}', [\App\Http\Controllers\MasterResikoController::class, 'updateCause'])->name('master-resiko.update-cause');
Route::delete('master-resiko/cause/{cause}', [\App\Http\Controllers\MasterResikoController::class, 'destroyCause'])->name('master-resiko.destroy-cause');

Route::get('/profile', function() {
    return view('profile');
})->name('profile');

// Logout handled by LoginController above
