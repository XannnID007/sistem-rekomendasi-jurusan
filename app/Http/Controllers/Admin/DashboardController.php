<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PesertaDidik;
use App\Models\PenilaianPesertaDidik;
use App\Models\PerhitunganTopsis;
use App\Services\TopsisCalculationService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $topsisService;

    public function __construct(TopsisCalculationService $topsisService)
    {
        $this->topsisService = $topsisService;
    }

    /**
     * Display the admin dashboard
     */
    public function index()
    {
        // Get current academic year
        $currentYear = '2024/2025';

        // Get statistics
        $totalPesertaDidik = PesertaDidik::where('tahun_ajaran', $currentYear)->count();
        $totalPenilaian = PenilaianPesertaDidik::where('tahun_ajaran', $currentYear)->count();
        $totalPerhitungan = PerhitunganTopsis::where('tahun_ajaran', $currentYear)->count();

        // Get recommendation distribution
        $tkjCount = PerhitunganTopsis::where('tahun_ajaran', $currentYear)
            ->where('jurusan_rekomendasi', 'TKJ')->count();
        $tkrCount = PerhitunganTopsis::where('tahun_ajaran', $currentYear)
            ->where('jurusan_rekomendasi', 'TKR')->count();

        // Get recent calculations
        $recentCalculations = PerhitunganTopsis::with('pesertaDidik')
            ->where('tahun_ajaran', $currentYear)
            ->orderBy('tanggal_perhitungan', 'desc')
            ->limit(5)
            ->get();

        // Get calculation statistics
        $statistics = $this->topsisService->getCalculationStatistics($currentYear);

        // Get monthly calculation trend (dummy data for now)
        $monthlyTrend = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'tkj' => [5, 8, 12, 15, 18, 22],
            'tkr' => [3, 5, 7, 9, 11, 13]
        ];

        return view('admin.dashboard', compact(
            'totalPesertaDidik',
            'totalPenilaian',
            'totalPerhitungan',
            'tkjCount',
            'tkrCount',
            'recentCalculations',
            'statistics',
            'monthlyTrend',
            'currentYear'
        ));
    }
}
