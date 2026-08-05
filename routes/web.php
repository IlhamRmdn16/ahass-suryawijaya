<?php
use App\Http\Controllers\AntreanPrintController;
use App\Livewire\Antrean\Index as AntreanIndex;
use App\Livewire\Mekanik\Index as MekanikIndex;
use App\Livewire\Mekanik\Dashboard as MekanikDashboard;
use Illuminate\Support\Facades\Route;
use App\Livewire\JenisPekerjaan\Index as JenisPekerjaanIndex;

Route::middleware(['auth', 'role:super admin'])->group(function () {
    Route::get('/jenis-pekerjaan', JenisPekerjaanIndex::class)->name('jenis-pekerjaan.index');
});

Route::middleware(['auth', 'role:super admin|entry|viewer'])->group(function () {
    Route::get('/antrean', AntreanIndex::class)->name('antrean.index');
    Route::get('/antrean/{antrean}/print', [AntreanPrintController::class, 'show'])->name('antrean.print');
});

Route::middleware(['auth', 'role:super admin'])->group(function () {
    Route::get('/mekanik', MekanikIndex::class)->name('mekanik.index');
});

Route::middleware(['auth', 'role:mekanik'])->group(function () {
    Route::get('/mekanik/dashboard', MekanikDashboard::class)->name('mekanik.dashboard');
});


