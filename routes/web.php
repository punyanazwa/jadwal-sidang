<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\PerkaraController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PutusanController;
use App\Http\Controllers\SuratPerintahController;
use App\Http\Controllers\UndanganMediasiController;
use App\Http\Controllers\NotulensiController;

// Rute Pengguna Guest (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Rute Pengguna Auth (Sudah Login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ScheduleController::class, 'dashboard'])->name('dashboard');
    
    // Route Perkara
    Route::resource('perkara', PerkaraController::class);

    // Route Cetak/Print Jadwal Sidang
    Route::get('/schedules/print', [ScheduleController::class, 'print'])->name('schedules.print');

    // Route Schedules
    Route::resource('schedules', ScheduleController::class);

    // Route Putusan
    Route::resource('putusan', PutusanController::class);

    // Route Lihat File Surat Perintah (Wajib ditempatkan sebelum Route::resource)
    Route::get('/surat-perintah/{id}/view', [SuratPerintahController::class, 'viewFile'])->name('surat-perintah.view');

    // Route Sub-menu Daftar Mediasi (Dipisah per Halaman)
    Route::resource('surat-perintah', SuratPerintahController::class);
    Route::resource('undangan-mediasi', UndanganMediasiController::class);
    Route::resource('notulensi', NotulensiController::class);

    // Route Laporan (Mendukung /laporan maupun /laporan/PN, /laporan/PA, dst)
    Route::get('/laporan/{pengadilan?}', [ReportController::class, 'index'])->name('laporan.index');

    // Route Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});