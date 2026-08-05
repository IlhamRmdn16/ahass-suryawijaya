<?php

use App\Http\Controllers\AntreanPrintController;
use App\Livewire\Antrean\Index as AntreanIndex;
use App\Livewire\JenisPekerjaan\Index as JenisPekerjaanIndex;
use App\Livewire\Laporan\Index as LaporanIndex;
use App\Livewire\Mekanik\Dashboard as MekanikDashboard;
use App\Livewire\Mekanik\Index as MekanikIndex;
use App\Livewire\Monitor\Board as MonitorBoard;
use App\Livewire\Users\Index as UsersIndex;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman publik
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('antrean.index');
});

/*
|--------------------------------------------------------------------------
| Auth (bawaan Laravel Breeze)
|--------------------------------------------------------------------------
| File-file ini sudah otomatis ter-generate oleh `breeze:install livewire`,
| tidak perlu diubah.
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Redirect /dashboard bawaan Breeze -> /antrean
|--------------------------------------------------------------------------
| Supaya user yang baru login tidak nyasar ke halaman dashboard kosong.
*/
Route::get('/dashboard', function () {
    return redirect()->route('antrean.index');
})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Antrean -- bisa diakses super admin, entry, dan viewer (read only
| untuk viewer, diatur lewat permission di dalam komponennya sendiri)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:super admin|entry|viewer'])->group(function () {
    Route::get('/antrean', AntreanIndex::class)->name('antrean.index');
    Route::get('/antrean/{antrean}/print', [AntreanPrintController::class, 'show'])->name('antrean.print');
});

/*
|--------------------------------------------------------------------------
| Dashboard Mekanik -- khusus role mekanik
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:mekanik'])->group(function () {
    Route::get('/mekanik/dashboard', MekanikDashboard::class)->name('mekanik.dashboard');
});

/*
|--------------------------------------------------------------------------
| Monitor Board -- boleh diakses siapa saja yang sudah login (role apapun),
| karena memang untuk ditonton semua orang di bengkel lewat TV.
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/monitor', MonitorBoard::class)->name('monitor.board');
});

/*
|--------------------------------------------------------------------------
| Master data & administrasi -- khusus super admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:super admin'])->group(function () {
    Route::get('/mekanik', MekanikIndex::class)->name('mekanik.index');
    Route::get('/jenis-pekerjaan', JenisPekerjaanIndex::class)->name('jenis-pekerjaan.index');
    Route::get('/users', UsersIndex::class)->name('users.index');
});

/*
|--------------------------------------------------------------------------
| Laporan -- untuk super admin dan viewer
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:super admin|viewer'])->group(function () {
    Route::get('/laporan', LaporanIndex::class)->name('laporan.index');
});
