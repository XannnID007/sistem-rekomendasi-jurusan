<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use App\Models\PerhitunganTopsis;
use Illuminate\Http\Request;

class AnalisController extends Controller
{
    /**
     * Display analysis overview
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
            return view('student.analisis.index', [
                'hasAnalysis' => false,
                'pesertaDidik' => $pesertaDidik
            ]);
        }

        // Load related data
        $perhitungan->load('penilaian');

        // Get all criteria for analysis
        $kriteria = Kriteria::active()->orderBy('kode_kriteria')->get();

        // Get process overview
        $processOverview = $this->getProcessOverview($perhitungan);

        // Get step-by-step analysis
        $stepAnalysis = $this->getStepAnalysis($perhitungan);

        return view('student.analisis.index', compact(
            'perhitungan',
            'pesertaDidik',
            'kriteria',
            'processOverview',
            'stepAnalysis'
        ))->with('hasAnalysis', true);
    }

    /**
     * Display detailed TOPSIS calculation
     */
    public function topsisDetail()
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
                ->route('student.analisis.index')
                ->with('error', 'Belum ada hasil analisis');
        }

        // Load related data
        $perhitungan->load('penilaian');

        // Get all students' data for matrix comparison (anonymized)
        $allPerhitungan = PerhitunganTopsis::with('penilaian')
            ->where('tahun_ajaran', $perhitungan->tahun_ajaran)
            ->get();

        // Get TOPSIS calculation steps
        $topsisSteps = $this->getTopsisCalculationSteps($perhitungan, $allPerhitungan);

        // Get criteria information
        $kriteria = Kriteria::active()->orderBy('kode_kriteria')->get();

        return view('student.analisis.topsis', compact(
            'perhitungan',
            'pesertaDidik',
            'topsisSteps',
            'kriteria',
            'allPerhitungan'
        ));
    }

    /**
     * Display criteria details
     */
    public function kriteriaDetail()
    {
        $user = auth()->user();
        $pesertaDidik = $user->pesertaDidik;

        if (!$pesertaDidik) {
            return redirect()->route('login')->with('error', 'Data peserta didik tidak ditemukan');
        }

        // Get all criteria
        $kriteria = Kriteria::active()->orderBy('kode_kriteria')->get();

        // Group criteria by category
        $kriteriaGrouped = [
            'Nilai Akademik' => $kriteria->whereIn('kode_kriteria', ['N1', 'N2', 'N3', 'N4', 'N5', 'N6']),
            'Minat' => $kriteria->whereIn('kode_kriteria', ['MA', 'MB', 'MC', 'MD']),
            'Lainnya' => $kriteria->whereIn('kode_kriteria', ['BB', 'BP'])
        ];

        // Get student's values if calculation exists
        $perhitungan = $pesertaDidik->perhitunganTerbaru;
        $studentValues = null;

        if ($perhitungan) {
            $perhitungan->load('penilaian');
            $studentValues = $this->getStudentCriteriaValues($perhitungan);
        }

        return view('student.analisis.kriteria', compact(
            'kriteria',
            'kriteriaGrouped',
            'pesertaDidik',
            'studentValues'
        ));
    }

    /**
     * Get process overview
     */
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

    /**
     * Get step-by-step analysis
     */
    private function getStepAnalysis($perhitungan)
    {
        $penilaian = $perhitungan->penilaian;

        return [
            'step1' => [
                'title' => 'Pengumpulan Data',
                'description' => 'Data nilai akademik, minat, keahlian, dan latar belakang ekonomi dikumpulkan',
                'data' => [
                    'nilai_akademik' => $penilaian->nilai_akademik,
                    'minat' => $penilaian->minat,
                    'keahlian' => $penilaian->keahlian,
                    'penghasilan_ortu' => $penilaian->penghasilan_ortu
                ]
            ],
            'step2' => [
                'title' => 'Konversi Data',
                'description' => 'Data non-numerik dikonversi menjadi nilai numerik untuk perhitungan',
                'conversions' => [
                    'minat_a' => $penilaian->convertMinatToNumeric($penilaian->minat_a),
                    'minat_b' => $penilaian->convertMinatToNumeric($penilaian->minat_b),
                    'minat_c' => $penilaian->convertMinatToNumeric($penilaian->minat_c),
                    'minat_d' => $penilaian->convertMinatToNumeric($penilaian->minat_d),
                    'keahlian' => $penilaian->convertKeahlianToNumeric($penilaian->keahlian),
                    'penghasilan' => $penilaian->convertPenghasilanToNumeric($penilaian->penghasilan_ortu)
                ]
            ],
            'step3' => [
                'title' => 'Normalisasi',
                'description' => 'Matriks keputusan dinormalisasi menggunakan metode euclidean',
                'normalized_values' => $perhitungan->normalized_values
            ],
            'step4' => [
                'title' => 'Pembobotan',
                'description' => 'Nilai ternormalisasi dikalikan dengan bobot masing-masing kriteria',
                'weighted_values' => $perhitungan->weighted_values
            ],
            'step5' => [
                'title' => 'Solusi Ideal',
                'description' => 'Ditentukan solusi ideal positif dan negatif',
                'distances' => [
                    'positive' => $perhitungan->jarak_positif,
                    'negative' => $perhitungan->jarak_negatif
                ]
            ],
            'step6' => [
                'title' => 'Nilai Preferensi',
                'description' => 'Dihitung nilai preferensi dan ditentukan rekomendasi',
                'result' => [
                    'preference_score' => $perhitungan->nilai_preferensi,
                    'recommendation' => $perhitungan->jurusan_rekomendasi,
                    'explanation' => $perhitungan->nilai_preferensi > 0.30 ?
                        'Nilai preferensi > 0.30, direkomendasikan TKJ' :
                        'Nilai preferensi ≤ 0.30, direkomendasikan TKR'
                ]
            ]
        ];
    }

    /**
     * Get TOPSIS calculation steps
     */
    private function getTopsisCalculationSteps($perhitungan, $allPerhitungan)
    {
        $steps = [];

        // Step 1: Decision Matrix
        $decisionMatrix = [];
        foreach ($allPerhitungan as $index => $calc) {
            $penilaian = $calc->penilaian;
            $decisionMatrix[] = [
                'student' => 'Siswa ' . ($index + 1) . ($calc->perhitungan_id === $perhitungan->perhitungan_id ? ' (Anda)' : ''),
                'values' => [
                    $penilaian->nilai_ipa,
                    $penilaian->nilai_ips,
                    $penilaian->nilai_matematika,
                    $penilaian->nilai_bahasa_indonesia,
                    $penilaian->nilai_bahasa_inggris,
                    $penilaian->nilai_produktif,
                    $penilaian->convertMinatToNumeric($penilaian->minat_a),
                    $penilaian->convertMinatToNumeric($penilaian->minat_b),
                    $penilaian->convertMinatToNumeric($penilaian->minat_c),
                    $penilaian->convertMinatToNumeric($penilaian->minat_d),
                    $penilaian->convertKeahlianToNumeric($penilaian->keahlian),
                    $penilaian->convertPenghasilanToNumeric($penilaian->penghasilan_ortu)
                ]
            ];
        }

        $steps['decision_matrix'] = $decisionMatrix;

        // Step 2: Normalized Matrix (only show current student's values)
        $steps['normalized_matrix'] = [
            'your_values' => array_values($perhitungan->normalized_values),
            'explanation' => 'Setiap nilai dibagi dengan akar kuadrat dari jumlah kuadrat semua nilai pada kolom yang sama'
        ];

        // Step 3: Weighted Matrix
        $steps['weighted_matrix'] = [
            'your_values' => array_values($perhitungan->weighted_values),
            'weights' => Kriteria::active()->orderBy('kode_kriteria')->pluck('bobot')->toArray(),
            'explanation' => 'Nilai ternormalisasi dikalikan dengan bobot masing-masing kriteria'
        ];

        // Step 4: Ideal Solutions
        $steps['ideal_solutions'] = [
            'distances' => [
                'positive' => $perhitungan->jarak_positif,
                'negative' => $perhitungan->jarak_negatif
            ],
            'explanation' => 'Dihitung jarak euclidean ke solusi ideal positif dan negatif'
        ];

        // Step 5: Preference Score
        $steps['preference_score'] = [
            'score' => $perhitungan->nilai_preferensi,
            'formula' => 'D⁻ / (D⁺ + D⁻)',
            'calculation' => number_format($perhitungan->jarak_negatif, 6) . ' / (' .
                number_format($perhitungan->jarak_positif, 6) . ' + ' .
                number_format($perhitungan->jarak_negatif, 6) . ') = ' .
                number_format($perhitungan->nilai_preferensi, 6)
        ];

        return $steps;
    }

    /**
     * Get student's criteria values
     */
    private function getStudentCriteriaValues($perhitungan)
    {
        $penilaian = $perhitungan->penilaian;

        return [
            'N1' => ['raw' => $penilaian->nilai_ipa, 'normalized' => $perhitungan->normalized_n1, 'weighted' => $perhitungan->weighted_n1],
            'N2' => ['raw' => $penilaian->nilai_ips, 'normalized' => $perhitungan->normalized_n2, 'weighted' => $perhitungan->weighted_n2],
            'N3' => ['raw' => $penilaian->nilai_matematika, 'normalized' => $perhitungan->normalized_n3, 'weighted' => $perhitungan->weighted_n3],
            'N4' => ['raw' => $penilaian->nilai_bahasa_indonesia, 'normalized' => $perhitungan->normalized_n4, 'weighted' => $perhitungan->weighted_n4],
            'N5' => ['raw' => $penilaian->nilai_bahasa_inggris, 'normalized' => $perhitungan->normalized_n5, 'weighted' => $perhitungan->weighted_n5],
            'N6' => ['raw' => $penilaian->nilai_produktif, 'normalized' => $perhitungan->normalized_n6, 'weighted' => $perhitungan->weighted_n6],
            'MA' => ['raw' => $penilaian->minat_a . ' (' . $penilaian->convertMinatToNumeric($penilaian->minat_a) . ')', 'normalized' => $perhitungan->normalized_ma, 'weighted' => $perhitungan->weighted_ma],
            'MB' => ['raw' => $penilaian->minat_b . ' (' . $penilaian->convertMinatToNumeric($penilaian->minat_b) . ')', 'normalized' => $perhitungan->normalized_mb, 'weighted' => $perhitungan->weighted_mb],
            'MC' => ['raw' => $penilaian->minat_c . ' (' . $penilaian->convertMinatToNumeric($penilaian->minat_c) . ')', 'normalized' => $perhitungan->normalized_mc, 'weighted' => $perhitungan->weighted_mc],
            'MD' => ['raw' => $penilaian->minat_d . ' (' . $penilaian->convertMinatToNumeric($penilaian->minat_d) . ')', 'normalized' => $perhitungan->normalized_md, 'weighted' => $perhitungan->weighted_md],
            'BB' => ['raw' => $penilaian->keahlian . ' (' . $penilaian->convertKeahlianToNumeric($penilaian->keahlian) . ')', 'normalized' => $perhitungan->normalized_bb, 'weighted' => $perhitungan->weighted_bb],
            'BP' => ['raw' => $penilaian->penghasilan_ortu . ' (' . $penilaian->convertPenghasilanToNumeric($penilaian->penghasilan_ortu) . ')', 'normalized' => $perhitungan->normalized_bp, 'weighted' => $perhitungan->weighted_bp]
        ];
    }
}
