<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\PerhitunganTopsis;
use Illuminate\Http\Request;

class RekomendasiController extends Controller
{
    /**
     * Display student's recommendation
     */
    public function index()
    {
        $user = auth()->user();
        $pesertaDidik = $user->pesertaDidik;

        if (!$pesertaDidik) {
            return redirect()->route('login')->with('error', 'Data peserta didik tidak ditemukan');
        }

        // Get latest calculation
        $perhitungan = $pesertaDidik->perhitunganTerbaru;

        if (!$perhitungan) {
            return view('student.rekomendasi.index', [
                'hasRecommendation' => false,
                'pesertaDidik' => $pesertaDidik
            ]);
        }

        // Load related data
        $perhitungan->load('penilaian');

        // Get ranking and statistics
        $ranking = PerhitunganTopsis::where('tahun_ajaran', $perhitungan->tahun_ajaran)
            ->where('nilai_preferensi', '>', $perhitungan->nilai_preferensi)
            ->count() + 1;

        $totalStudents = PerhitunganTopsis::where('tahun_ajaran', $perhitungan->tahun_ajaran)
            ->count();

        // Get percentile
        $percentile = round((($totalStudents - $ranking + 1) / $totalStudents) * 100);

        // Get comparison with other students
        $avgPreference = PerhitunganTopsis::where('tahun_ajaran', $perhitungan->tahun_ajaran)
            ->avg('nilai_preferensi');

        // Get students with same recommendation
        $sameRecommendation = PerhitunganTopsis::where('tahun_ajaran', $perhitungan->tahun_ajaran)
            ->where('jurusan_rekomendasi', $perhitungan->jurusan_rekomendasi)
            ->count();

        // Get recommendation explanation
        $explanation = $this->getRecommendationExplanation($perhitungan);

        return view('student.rekomendasi.index', compact(
            'perhitungan',
            'pesertaDidik',
            'ranking',
            'totalStudents',
            'percentile',
            'avgPreference',
            'sameRecommendation',
            'explanation'
        ))->with('hasRecommendation', true);
    }

    /**
     * Display detailed recommendation analysis
     */
    public function detail()
    {
        $user = auth()->user();
        $pesertaDidik = $user->pesertaDidik;

        if (!$pesertaDidik) {
            return redirect()->route('login')->with('error', 'Data peserta didik tidak ditemukan');
        }

        // Get latest calculation
        $perhitungan = $pesertaDidik->perhitunganTerbaru;

        if (!$perhitungan) {
            return redirect()
                ->route('student.rekomendasi.index')
                ->with('error', 'Belum ada hasil rekomendasi');
        }

        // Load related data
        $perhitungan->load('penilaian');

        // Get detailed analysis
        $analysis = $this->getDetailedAnalysis($perhitungan);

        // Get strength and weakness analysis
        $strengthWeakness = $this->getStrengthWeaknessAnalysis($perhitungan);

        // Get improvement suggestions
        $suggestions = $this->getImprovementSuggestions($perhitungan);

        return view('student.rekomendasi.detail', compact(
            'perhitungan',
            'pesertaDidik',
            'analysis',
            'strengthWeakness',
            'suggestions'
        ));
    }

    /**
     * Get recommendation explanation
     */
    private function getRecommendationExplanation($perhitungan)
    {
        $explanation = [
            'threshold' => 0.30,
            'your_score' => $perhitungan->nilai_preferensi,
            'recommendation' => $perhitungan->jurusan_rekomendasi
        ];

        if ($perhitungan->jurusan_rekomendasi === 'TKJ') {
            $explanation['reason'] = 'Nilai preferensi Anda (' . number_format($perhitungan->nilai_preferensi, 4) . ') berada di atas threshold 0.30, yang menunjukkan kesesuaian yang baik dengan jurusan Teknik Komputer dan Jaringan.';
            $explanation['description'] = 'TKJ (Teknik Komputer dan Jaringan) adalah jurusan yang fokus pada teknologi informasi, jaringan komputer, dan sistem informasi. Cocok untuk siswa yang memiliki minat tinggi pada teknologi dan komputer.';
            $explanation['career_prospects'] = [
                'Network Administrator',
                'System Administrator',
                'Web Developer',
                'IT Support Specialist',
                'Database Administrator',
                'Cyber Security Analyst'
            ];
        } else {
            $explanation['reason'] = 'Nilai preferensi Anda (' . number_format($perhitungan->nilai_preferensi, 4) . ') berada di bawah atau sama dengan threshold 0.30, yang menunjukkan kesesuaian yang baik dengan jurusan Teknik Kendaraan Ringan.';
            $explanation['description'] = 'TKR (Teknik Kendaraan Ringan) adalah jurusan yang fokus pada teknologi otomotif, mesin kendaraan, dan sistem transportasi. Cocok untuk siswa yang memiliki minat pada teknologi mekanik dan otomotif.';
            $explanation['career_prospects'] = [
                'Mekanik Otomotif',
                'Teknisi Kendaraan',
                'Quality Control Automotive',
                'Supervisor Bengkel',
                'Konsultan Otomotif',
                'Wirausaha Bengkel'
            ];
        }

        return $explanation;
    }

    /**
     * Get detailed analysis
     */
    private function getDetailedAnalysis($perhitungan)
    {
        $penilaian = $perhitungan->penilaian;

        return [
            'nilai_akademik' => [
                'ipa' => $penilaian->nilai_ipa,
                'ips' => $penilaian->nilai_ips,
                'matematika' => $penilaian->nilai_matematika,
                'bahasa_indonesia' => $penilaian->nilai_bahasa_indonesia,
                'bahasa_inggris' => $penilaian->nilai_bahasa_inggris,
                'produktif' => $penilaian->nilai_produktif,
                'rata_rata' => $penilaian->rata_nilai_akademik
            ],
            'minat' => [
                'minat_a' => $penilaian->minat_a,
                'minat_b' => $penilaian->minat_b,
                'minat_c' => $penilaian->minat_c,
                'minat_d' => $penilaian->minat_d
            ],
            'keahlian' => $penilaian->keahlian,
            'penghasilan_ortu' => $penilaian->penghasilan_ortu,
            'nilai_preferensi' => $perhitungan->nilai_preferensi,
            'rekomendasi' => $perhitungan->jurusan_rekomendasi
        ];
    }

    /**
     * Get strength and weakness analysis
     */
    private function getStrengthWeaknessAnalysis($perhitungan)
    {
        $penilaian = $perhitungan->penilaian;
        $nilaiAkademik = $penilaian->nilai_akademik;

        // Find strengths (highest scores)
        $strengths = [];
        $weaknesses = [];

        // Academic strengths
        $maxNilai = max($nilaiAkademik);
        $minNilai = min($nilaiAkademik);

        $akademikLabels = [
            'n1' => 'IPA',
            'n2' => 'IPS',
            'n3' => 'Matematika',
            'n4' => 'Bahasa Indonesia',
            'n5' => 'Bahasa Inggris',
            'n6' => 'Produktif'
        ];

        foreach ($nilaiAkademik as $key => $nilai) {
            if ($nilai >= 85) {
                $strengths[] = $akademikLabels[$key] . ' (' . $nilai . ')';
            } elseif ($nilai < 75) {
                $weaknesses[] = $akademikLabels[$key] . ' (' . $nilai . ')';
            }
        }

        // Interest analysis
        $teknologiInterests = ['Teknologi informasi & Komunikasi', 'Komputer', 'Desain Grafis', 'Fotografi & Videografi'];
        $teknikInterests = ['Elektronik', 'Mesin', 'Seni & Kerajinan'];

        $allMinat = [$penilaian->minat_a, $penilaian->minat_b, $penilaian->minat_c, $penilaian->minat_d];

        $teknologiCount = 0;
        $teknikCount = 0;

        foreach ($allMinat as $minat) {
            if (in_array($minat, $teknologiInterests)) {
                $teknologiCount++;
            } elseif (in_array($minat, $teknikInterests)) {
                $teknikCount++;
            }
        }

        if ($teknologiCount > $teknikCount) {
            $strengths[] = 'Minat tinggi pada teknologi dan komputer';
        } elseif ($teknikCount > $teknologiCount) {
            $strengths[] = 'Minat tinggi pada teknik dan mesin';
        }

        // Skills analysis
        $teknologiSkills = ['perangkat lunak', 'menganalisa', 'Menggunakan Perangkat Lunak & Komputer'];
        $teknikSkills = ['kelistrikan'];

        if (in_array($penilaian->keahlian, $teknologiSkills)) {
            $strengths[] = 'Keahlian dalam bidang teknologi: ' . $penilaian->keahlian;
        } elseif (in_array($penilaian->keahlian, $teknikSkills)) {
            $strengths[] = 'Keahlian dalam bidang teknik: ' . $penilaian->keahlian;
        }

        return [
            'strengths' => $strengths,
            'weaknesses' => $weaknesses
        ];
    }

    /**
     * Get improvement suggestions
     */
    private function getImprovementSuggestions($perhitungan)
    {
        $penilaian = $perhitungan->penilaian;
        $suggestions = [];

        // Academic improvement suggestions
        $nilaiAkademik = $penilaian->nilai_akademik;

        if ($nilaiAkademik['n1'] < 75) { // IPA
            $suggestions[] = 'Tingkatkan pemahaman mata pelajaran IPA dengan lebih banyak praktikum dan latihan soal';
        }

        if ($nilaiAkademik['n3'] < 75) { // Matematika
            $suggestions[] = 'Perkuat dasar-dasar matematika dengan latihan rutin dan bimbingan tambahan';
        }

        if ($nilaiAkademik['n5'] < 75) { // Bahasa Inggris
            $suggestions[] = 'Tingkatkan kemampuan bahasa Inggris dengan membaca, mendengarkan musik/film berbahasa Inggris';
        }

        // Interest-based suggestions
        if ($perhitungan->jurusan_rekomendasi === 'TKJ') {
            $suggestions[] = 'Pelajari lebih dalam tentang teknologi komputer dan jaringan';
            $suggestions[] = 'Ikuti kursus programming atau sertifikasi IT';
            $suggestions[] = 'Bergabung dengan komunitas teknologi atau coding club';
        } else {
            $suggestions[] = 'Pelajari lebih dalam tentang teknologi otomotif dan mesin';
            $suggestions[] = 'Ikuti kursus mekanik atau teknisi kendaraan';
            $suggestions[] = 'Bergabung dengan komunitas otomotif atau bengkel praktik';
        }

        // General suggestions
        $suggestions[] = 'Kembangkan soft skills seperti komunikasi dan teamwork';
        $suggestions[] = 'Ikuti magang atau praktik kerja di bidang yang diminati';

        // Economic consideration
        if (strpos($penilaian->penghasilan_ortu, 'G1') !== false) {
            $suggestions[] = 'Cari informasi tentang beasiswa atau bantuan pendidikan yang tersedia';
        }

        return $suggestions;
    }
}
