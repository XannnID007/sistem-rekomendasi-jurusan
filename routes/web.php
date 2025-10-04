<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\PublicSubmissionController;
use App\Http\Controllers\Admin\PerhitunganController;
use App\Http\Controllers\Admin\RekomendasiController;
use App\Http\Controllers\PublicRekomendasiController;
use App\Http\Controllers\Admin\PesertaDidikController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Welcome Page
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// ===== PUBLIC ROUTES - SUBMISSION FORM =====
// Ubah prefix dari 'rekomendasi' ke 'daftar' atau 'formulir'
Route::prefix('daftar')->name('submission.')->group(function () {
    Route::get('/', [PublicSubmissionController::class, 'index'])->name('index');
    Route::post('/submit', [PublicSubmissionController::class, 'submit'])->name('submit');
    Route::get('/{nisn}/result', [PublicSubmissionController::class, 'result'])->name('result');
    Route::post('/{nisn}/approve', [PublicSubmissionController::class, 'approve'])->name('approve');
    Route::post('/{nisn}/reject', [PublicSubmissionController::class, 'reject'])->name('reject');
    Route::get('/{nisn}/certificate', [PublicSubmissionController::class, 'certificate'])->name('certificate');
    Route::get('/{nisn}/download-pdf', [PublicSubmissionController::class, 'downloadPdf'])->name('download-pdf');
});

// ===== PUBLIC ROUTES - CEK REKOMENDASI (untuk yang sudah ada data) =====
Route::prefix('rekomendasi')->name('rekomendasi.')->group(function () {
    Route::get('/', [PublicRekomendasiController::class, 'index'])->name('index');
    Route::get('/search', [PublicRekomendasiController::class, 'search'])->name('search');
    Route::get('/{nisn}', [PublicRekomendasiController::class, 'show'])->name('show');
    Route::get('/{nisn}/detail', [PublicRekomendasiController::class, 'detail'])->name('detail');
    Route::get('/{nisn}/analisis', [PublicRekomendasiController::class, 'analisis'])->name('analisis');
});

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
        Route::get('/get-students', [LaporanController::class, 'getStudents'])->name('get-students');
        Route::post('/', [LaporanController::class, 'store'])->name('store');
        Route::get('/{laporan}', [LaporanController::class, 'show'])->name('show');
        Route::get('/{laporan}/download', [LaporanController::class, 'download'])->name('download');
        Route::delete('/{laporan}', [LaporanController::class, 'destroy'])->name('destroy');

        // Generate specific reports
        Route::post('/generate/individual', [LaporanController::class, 'generateIndividual'])->name('generate.individual');
        Route::post('/generate/summary', [LaporanController::class, 'generateSummary'])->name('generate.summary');
        Route::post('/generate/comparison', [LaporanController::class, 'generateComparison'])->name('generate.comparison');
        Route::post('/generate/recommendation', [LaporanController::class, 'generateByRecommendation'])->name('generate.recommendation');
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

    // Submission Management (Admin)
    Route::prefix('submission')->name('submission.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\SubmissionController::class, 'index'])->name('index');
        Route::get('/{pesertaDidik}', [\App\Http\Controllers\Admin\SubmissionController::class, 'show'])->name('show');
        Route::post('/{pesertaDidik}/approve', [\App\Http\Controllers\Admin\SubmissionController::class, 'approve'])->name('approve');
        Route::post('/{pesertaDidik}/override', [\App\Http\Controllers\Admin\SubmissionController::class, 'overrideJurusan'])->name('override');
        Route::delete('/{pesertaDidik}', [\App\Http\Controllers\Admin\SubmissionController::class, 'destroy'])->name('destroy');
        Route::get('/export/csv', [\App\Http\Controllers\Admin\SubmissionController::class, 'export'])->name('export');
    });
});

// Redirect to admin dashboard if authenticated
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    })->name('dashboard');

    Route::get('/home', function () {
        return redirect()->route('dashboard');
    });
});
