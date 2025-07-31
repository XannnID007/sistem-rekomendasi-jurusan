<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the student dashboard
     */
    public function index()
    {
        $user = auth()->user();
        $pesertaDidik = $user->pesertaDidik;

        if (!$pesertaDidik) {
            return redirect()->route('login')->with('error', 'Data peserta didik tidak ditemukan');
        }

        // Load relationships
        $pesertaDidik->load(['penilaianTerbaru', 'perhitunganTerbaru']);

        // Get assessment status
        $hasPenilaian = $pesertaDidik->penilaianTerbaru ? true : false;
        $hasCalculation = $pesertaDidik->perhitunganTerbaru ? true : false;

        // Get recommendation if exists
        $rekomendasi = null;
        $nilaiPreferensi = null;
        $ranking = null;
        $totalStudents = null;

        if ($hasCalculation) {
            $perhitungan = $pesertaDidik->perhitunganTerbaru;
            $rekomendasi = $perhitungan->jurusan_rekomendasi;
            $nilaiPreferensi = $perhitungan->nilai_preferensi;

            // Get ranking among all students
            $ranking = \App\Models\PerhitunganTopsis::where('tahun_ajaran', $perhitungan->tahun_ajaran)
                ->where('nilai_preferensi', '>', $nilaiPreferensi)
                ->count() + 1;

            $totalStudents = \App\Models\PerhitunganTopsis::where('tahun_ajaran', $perhitungan->tahun_ajaran)
                ->count();
        }

        // Get academic performance if assessment exists
        $nilaiAkademik = null;
        if ($hasPenilaian) {
            $penilaian = $pesertaDidik->penilaianTerbaru;
            $nilaiAkademik = [
                'rata_nilai' => $penilaian->rata_nilai_akademik,
                'nilai_tertinggi' => max($penilaian->nilai_akademik),
                'nilai_terendah' => min($penilaian->nilai_akademik),
                'detail' => $penilaian->nilai_akademik
            ];
        }

        // Get profile completion percentage
        $profileCompletion = $this->calculateProfileCompletion($pesertaDidik);

        return view('student.dashboard', compact(
            'pesertaDidik',
            'hasPenilaian',
            'hasCalculation',
            'rekomendasi',
            'nilaiPreferensi',
            'ranking',
            'totalStudents',
            'nilaiAkademik',
            'profileCompletion'
        ));
    }

    /**
     * Calculate profile completion percentage
     */
    private function calculateProfileCompletion($pesertaDidik)
    {
        $fields = [
            'alamat' => $pesertaDidik->alamat,
            'no_telepon' => $pesertaDidik->no_telepon,
            'nama_orang_tua' => $pesertaDidik->nama_orang_tua,
            'no_telepon_orang_tua' => $pesertaDidik->no_telepon_orang_tua,
        ];

        $filledFields = array_filter($fields, function ($value) {
            return !empty($value);
        });

        $baseFields = 6; // Required fields that are always filled
        $optionalFields = count($fields);
        $completedOptional = count($filledFields);

        $totalFields = $baseFields + $optionalFields;
        $completedFields = $baseFields + $completedOptional;

        return round(($completedFields / $totalFields) * 100);
    }
}
