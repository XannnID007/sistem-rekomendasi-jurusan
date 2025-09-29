<?php

namespace App\Http\Controllers;

use App\Models\PesertaDidik;
use App\Models\PerhitunganTopsis;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class PublicRekomendasiController extends Controller
{
    /**
     * Halaman utama rekomendasi - Form pencarian
     */
    public function index()
    {
        // Get statistics untuk ditampilkan
        $statistics = [
            'total_siswa' => PesertaDidik::count(),
            'total_perhitungan' => PerhitunganTopsis::count(),
            'tkj_count' => PerhitunganTopsis::where('jurusan_rekomendasi', 'TKJ')->count(),
            'tkr_count' => PerhitunganTopsis::where('jurusan_rekomendasi', 'TKR')->count(),
        ];

        return view('public.rekomendasi.index', compact('statistics'));
    }

    /**
     * Search rekomendasi berdasarkan NISN
     */
    public function search(Request $request)
    {
        $request->validate([
            'nisn' => 'required|digits:10'
        ], [
            'nisn.required' => 'NISN wajib diisi',
            'nisn.digits' => 'NISN harus 10 digit'
        ]);

        $nisn = $request->nisn;

        // Cari peserta didik berdasarkan NISN
        $pesertaDidik = PesertaDidik::where('nisn', $nisn)->first();

        if (!$pesertaDidik) {
            return back()
                ->withInput()
                ->with('error', 'NISN tidak ditemukan dalam sistem. Pastikan NISN yang Anda masukkan sudah benar.');
        }

        // Redirect ke halaman show
        return redirect()->route('rekomendasi.show', $nisn);
    }

    /**
     * Tampilkan rekomendasi berdasarkan NISN
     */
    public function show($nisn)
    {
        $pesertaDidik = PesertaDidik::where('nisn', $nisn)->first();

        if (!$pesertaDidik) {
            return redirect()->route('rekomendasi.index')
                ->with('error', 'Data peserta didik tidak ditemukan.');
        }

        // Load relationships
        $pesertaDidik->load(['penilaianTerbaru', 'perhitunganTerbaru']);

        // Cek apakah ada penilaian
        $hasPenilaian = $pesertaDidik->penilaianTerbaru ? true : false;

        // Cek apakah ada perhitungan
        $hasCalculation = $pesertaDidik->perhitunganTerbaru ? true : false;

        if (!$hasCalculation) {
            return view('public.rekomendasi.show', [
                'pesertaDidik' => $pesertaDidik,
                'hasPenilaian' => $hasPenilaian,
                'hasCalculation' => false
            ]);
        }

        $perhitungan = $pesertaDidik->perhitunganTerbaru;
        $perhitungan->load('penilaian');

        // Get ranking and statistics
        $ranking = PerhitunganTopsis::where('tahun_ajaran', $perhitungan->tahun_ajaran)
            ->where('nilai_preferensi', '>', $perhitungan->nilai_preferensi)
            ->count() + 1;

        $totalStudents = PerhitunganTopsis::where('tahun_ajaran', $perhitungan->tahun_ajaran)
            ->count();

        $percentile = round((($totalStudents - $ranking + 1) / $totalStudents) * 100);

        $avgPreference = PerhitunganTopsis::where('tahun_ajaran', $perhitungan->tahun_ajaran)
            ->avg('nilai_preferensi');

        $sameRecommendation = PerhitunganTopsis::where('tahun_ajaran', $perhitungan->tahun_ajaran)
            ->where('jurusan_rekomendasi', $perhitungan->jurusan_rekomendasi)
            ->count();

        // Get explanation
        $explanation = $this->getRecommendationExplanation($perhitungan);

        return view('public.rekomendasi.show', compact(
            'pesertaDidik',
            'perhitungan',
            'hasPenilaian',
            'hasCalculation',
            'ranking',
            'totalStudents',
            'percentile',
            'avgPreference',
            'sameRecommendation',
            'explanation'
        ));
    }

    /**
     * Detail analisis lengkap
     */
    public function detail($nisn)
    {
        $pesertaDidik = PesertaDidik::where('nisn', $nisn)->first();

        if (!$pesertaDidik || !$pesertaDidik->perhitunganTerbaru) {
            return redirect()->route('rekomendasi.index')
                ->with('error', 'Data rekomendasi tidak tersedia.');
        }

        $perhitungan = $pesertaDidik->perhitunganTerbaru;
        $perhitungan->load('penilaian');

        // Get detailed analysis
        $analysis = $this->getDetailedAnalysis($perhitungan);
        $strengthWeakness = $this->getStrengthWeaknessAnalysis($perhitungan);
        $suggestions = $this->getImprovementSuggestions($perhitungan);

        return view('public.rekomendasi.detail', compact(
            'pesertaDidik',
            'perhitungan',
            'analysis',
            'strengthWeakness',
            'suggestions'
        ));
    }

    /**
     * Detail perhitungan TOPSIS
     */
    public function analisis($nisn)
    {
        $pesertaDidik = PesertaDidik::where('nisn', $nisn)->first();

        if (!$pesertaDidik || !$pesertaDidik->perhitunganTerbaru) {
            return redirect()->route('rekomendasi.index')
                ->with('error', 'Data perhitungan tidak tersedia.');
        }

        $perhitungan = $pesertaDidik->perhitunganTerbaru;
        $perhitungan->load('penilaian');

        // Get all criteria
        $kriteria = Kriteria::active()->orderBy('kode_kriteria')->get();

        // Get process overview
        $processOverview = $this->getProcessOverview($perhitungan);

        // Get all perhitungan for matrix comparison
        $allPerhitungan = PerhitunganTopsis::with('penilaian')
            ->where('tahun_ajaran', $perhitungan->tahun_ajaran)
            ->get();

        return view('public.rekomendasi.analisis', compact(
            'pesertaDidik',
            'perhitungan',
            'kriteria',
            'processOverview',
            'allPerhitungan'
        ));
    }

    // Helper methods
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
                'produktif' => $penilaian->nilai_pkn,
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

    private function getStrengthWeaknessAnalysis($perhitungan)
    {
        $penilaian = $perhitungan->penilaian;
        $nilaiAkademik = $penilaian->nilai_akademik;

        $strengths = [];
        $weaknesses = [];

        $akademikLabels = [
            'n1' => 'IPA',
            'n2' => 'IPS',
            'n3' => 'Matematika',
            'n4' => 'Bahasa Indonesia',
            'n5' => 'Bahasa Inggris',
            'n6' => 'PKN'
        ];

        foreach ($nilaiAkademik as $key => $nilai) {
            if ($nilai >= 85) {
                $strengths[] = $akademikLabels[$key] . ' (' . $nilai . ')';
            } elseif ($nilai < 75) {
                $weaknesses[] = $akademikLabels[$key] . ' (' . $nilai . ')';
            }
        }

        return [
            'strengths' => $strengths,
            'weaknesses' => $weaknesses
        ];
    }

    private function getImprovementSuggestions($perhitungan)
    {
        $penilaian = $perhitungan->penilaian;
        $suggestions = [];

        $nilaiAkademik = $penilaian->nilai_akademik;

        if ($nilaiAkademik['n1'] < 75) {
            $suggestions[] = 'Tingkatkan pemahaman mata pelajaran IPA dengan lebih banyak praktikum dan latihan soal';
        }

        if ($nilaiAkademik['n3'] < 75) {
            $suggestions[] = 'Perkuat dasar-dasar matematika dengan latihan rutin dan bimbingan tambahan';
        }

        if ($perhitungan->jurusan_rekomendasi === 'TKJ') {
            $suggestions[] = 'Pelajari lebih dalam tentang teknologi komputer dan jaringan';
            $suggestions[] = 'Ikuti kursus programming atau sertifikasi IT';
        } else {
            $suggestions[] = 'Pelajari lebih dalam tentang teknologi otomotif dan mesin';
            $suggestions[] = 'Ikuti kursus mekanik atau teknisi kendaraan';
        }

        $suggestions[] = 'Kembangkan soft skills seperti komunikasi dan teamwork';
        $suggestions[] = 'Ikuti magang atau praktik kerja di bidang yang diminati';

        return $suggestions;
    }

    private function getProcessOverview($perhitungan)
    {
        return [
            'total_criteria' => 12,
            'calculation_date' => $perhitungan->tanggal_perhitungan,
            'preference_score' => $perhitungan->nilai_preferensi,
            'recommendation' => $perhitungan->jurusan_rekomendasi,
            'threshold' => 0.30,
            'academic_year' => $perhitungan->tahun_ajaran
        ];
    }
}
