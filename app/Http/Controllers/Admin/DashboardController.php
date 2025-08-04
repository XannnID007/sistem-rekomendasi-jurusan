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

        // Get recent calculations with safe date handling
        $recentCalculations = PerhitunganTopsis::with('pesertaDidik')
            ->where('tahun_ajaran', $currentYear)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($calculation) {
                // Ensure tanggal_perhitungan is properly formatted
                $tanggalPerhitungan = $calculation->getTanggalPerhitunganFormatted();
                $calculation->tanggal_perhitungan_safe = $tanggalPerhitungan ?: $calculation->created_at;
                return $calculation;
            });

        // Get calculation statistics
        try {
            $statistics = $this->topsisService->getCalculationStatistics($currentYear);
        } catch (\Exception $e) {
            $statistics = [
                'total_calculations' => $totalPerhitungan,
                'tkj_recommendations' => $tkjCount,
                'tkr_recommendations' => $tkrCount,
                'average_preference_score' => 0,
                'highest_preference_score' => 0,
                'lowest_preference_score' => 0,
            ];
        }

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
