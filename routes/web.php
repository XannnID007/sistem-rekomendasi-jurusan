<?php
// routes/web.php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PesertaDidikController;
use App\Http\Controllers\Admin\PerhitunganController;
use App\Http\Controllers\Admin\RekomendasiController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\RekomendasiController as StudentRekomendasiController;
use App\Http\Controllers\Student\AnalisController;
use App\Http\Controllers\Student\ProfilController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Welcome Page
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Peserta Didik Management
    Route::prefix('peserta-didik')->name('peserta-didik.')->group(function () {
        Route::get('/', [PesertaDidikController::class, 'index'])->name('index');
        Route::get('/create', [PesertaDidikController::class, 'create'])->name('create');
        Route::post('/', [PesertaDidikController::class, 'store'])->name('store');
        Route::get('/{pesertaDidik}', [PesertaDidikController::class, 'show'])->name('show');
        Route::get('/{pesertaDidik}/edit', [PesertaDidikController::class, 'edit'])->name('edit');
        Route::put('/{pesertaDidik}', [PesertaDidikController::class, 'update'])->name('update');
        Route::delete('/{pesertaDidik}', [PesertaDidikController::class, 'destroy'])->name('destroy');

        // Penilaian routes
        Route::get('/{pesertaDidik}/penilaian/create', [PesertaDidikController::class, 'createPenilaian'])->name('penilaian.create');
        Route::post('/{pesertaDidik}/penilaian', [PesertaDidikController::class, 'storePenilaian'])->name('penilaian.store');
        Route::get('/{pesertaDidik}/penilaian/{penilaian}/edit', [PesertaDidikController::class, 'editPenilaian'])->name('penilaian.edit');
        Route::put('/{pesertaDidik}/penilaian/{penilaian}', [PesertaDidikController::class, 'updatePenilaian'])->name('penilaian.update');
        Route::delete('/{pesertaDidik}/penilaian/{penilaian}', [PesertaDidikController::class, 'destroyPenilaian'])->name('penilaian.destroy');
    });

    // Perhitungan TOPSIS
    Route::prefix('perhitungan')->name('perhitungan.')->group(function () {
        Route::get('/', [PerhitunganController::class, 'index'])->name('index');
        Route::get('/create', [PerhitunganController::class, 'create'])->name('create');
        Route::post('/calculate', [PerhitunganController::class, 'calculate'])->name('calculate');
        Route::get('/{perhitungan}', [PerhitunganController::class, 'show'])->name('show');
        Route::delete('/{perhitungan}', [PerhitunganController::class, 'destroy'])->name('destroy');
        Route::post('/calculate-all', [PerhitunganController::class, 'calculateAll'])->name('calculate-all');
        Route::get('/detail/{pesertaDidik}', [PerhitunganController::class, 'detail'])->name('detail');
    });

    // Hasil Rekomendasi
    Route::prefix('rekomendasi')->name('rekomendasi.')->group(function () {
        Route::get('/', [RekomendasiController::class, 'index'])->name('index');
        Route::get('/export', [RekomendasiController::class, 'export'])->name('export');
        Route::get('/filter', [RekomendasiController::class, 'filter'])->name('filter');
        Route::get('/{perhitungan}/detail', [RekomendasiController::class, 'detail'])->name('detail');
    });

    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/create', [LaporanController::class, 'create'])->name('create');
        Route::post('/', [LaporanController::class, 'store'])->name('store');
        Route::get('/{laporan}', [LaporanController::class, 'show'])->name('show');
        Route::get('/{laporan}/download', [LaporanController::class, 'download'])->name('download');
        Route::delete('/{laporan}', [LaporanController::class, 'destroy'])->name('destroy');

        // Generate specific reports
        Route::post('/generate/individual', [LaporanController::class, 'generateIndividual'])->name('generate.individual');
        Route::post('/generate/summary', [LaporanController::class, 'generateSummary'])->name('generate.summary');
        Route::post('/generate/comparison', [LaporanController::class, 'generateComparison'])->name('generate.comparison');
    });

    // Kriteria Management
    Route::prefix('kriteria')->name('kriteria.')->group(function () {
        Route::get('/', [KriteriaController::class, 'index'])->name('index');
        Route::get('/create', [KriteriaController::class, 'create'])->name('create');
        Route::post('/', [KriteriaController::class, 'store'])->name('store');
        Route::get('/{kriteria}', [KriteriaController::class, 'show'])->name('show');
        Route::get('/{kriteria}/edit', [KriteriaController::class, 'edit'])->name('edit');
        Route::put('/{kriteria}', [KriteriaController::class, 'update'])->name('update');
        Route::delete('/{kriteria}', [KriteriaController::class, 'destroy'])->name('destroy');
        Route::post('/reset-weights', [KriteriaController::class, 'resetWeights'])->name('reset-weights');
    });
});

// Student Routes
Route::middleware(['auth', 'student'])->prefix('student')->name('student.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

    // Hasil Rekomendasi
    Route::prefix('rekomendasi')->name('rekomendasi.')->group(function () {
        Route::get('/', [StudentRekomendasiController::class, 'index'])->name('index');
        Route::get('/detail', [StudentRekomendasiController::class, 'detail'])->name('detail');
    });

    // Detail Analisis
    Route::prefix('analisis')->name('analisis.')->group(function () {
        Route::get('/', [AnalisController::class, 'index'])->name('index');
        Route::get('/topsis', [AnalisController::class, 'topsisDetail'])->name('topsis');
        Route::get('/kriteria', [AnalisController::class, 'kriteriaDetail'])->name('kriteria');
    });

    // Profil
    Route::prefix('profil')->name('profil.')->group(function () {
        Route::get('/', [ProfilController::class, 'index'])->name('index');
        Route::get('/edit', [ProfilController::class, 'edit'])->name('edit');
        Route::put('/', [ProfilController::class, 'update'])->name('update');
        Route::get('/password', [ProfilController::class, 'password'])->name('password');
        Route::put('/password', [ProfilController::class, 'updatePassword'])->name('password.update');
    });
});

// Redirect routes based on user role
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('student.dashboard');
        }
    })->name('dashboard');

    Route::get('/home', function () {
        return redirect()->route('dashboard');
    });
});
