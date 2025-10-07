<?php

namespace App\Services;

use Exception;
use App\Models\Kriteria;
use App\Models\PerhitunganTopsis;
use App\Models\PenilaianPesertaDidik;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TopsisCalculationService
{
     private Collection $criteria;
     private array $weights;

     public function __construct()
     {
          $this->criteria = Kriteria::active()->orderBy('kode_kriteria')->get();
          $this->weights = $this->getCriteriaWeights();
     }

     /**
      * Konversi nilai rapor (N1-N6) ke bobot sesuai aturan di Excel.
      */
     private function convertNilaiToBobot(float $nilai, string $kategori): float
     {
          // Aturan untuk N1 (IPA) & N4 (Matematika)
          if (in_array($kategori, ['N1', 'N4'])) {
               if ($nilai > 90) return 4.0;
               if ($nilai >= 81) return 3.0;
               if ($nilai >= 76) return 2.0;
               return 1.0;
          }

          // Aturan untuk N5 (B.Indonesia)
          if ($kategori === 'N5') {
               if ($nilai > 90) return 4.0;
               if ($nilai >= 80) return 3.0;
               if ($nilai >= 61) return 2.0;
               return 1.0;
          }

          // Aturan Umum untuk N2, N3, N6 (IPS, B.Inggris, PKN)
          if (in_array($kategori, ['N2', 'N3', 'N6'])) {
               if ($nilai > 89) return 4.0;
               if ($nilai >= 80) return 3.0;
               if ($nilai >= 61) return 2.0;
               return 1.0;
          }

          return 1.0; // Fallback
     }

     /**
      * Membangun matriks keputusan dari data penilaian.
      */
     private function buildDecisionMatrix(Collection $assessments): array
     {
          $matrix = [];
          foreach ($assessments as $assessment) {
               if (!$this->isAssessmentValid($assessment)) continue;

               $row = [
                    'penilaian_id' => $assessment->penilaian_id,
                    'peserta_didik_id' => $assessment->peserta_didik_id,
                    'tahun_ajaran' => $assessment->tahun_ajaran,
                    'n1' => $this->convertNilaiToBobot((float)$assessment->nilai_ipa, 'N1'),
                    'n2' => $this->convertNilaiToBobot((float)$assessment->nilai_ips, 'N2'),
                    'n3' => $this->convertNilaiToBobot((float)$assessment->nilai_bahasa_inggris, 'N3'),
                    'n4' => $this->convertNilaiToBobot((float)$assessment->nilai_matematika, 'N4'),
                    'n5' => $this->convertNilaiToBobot((float)$assessment->nilai_bahasa_indonesia, 'N5'),
                    'n6' => $this->convertNilaiToBobot((float)$assessment->nilai_pkn, 'N6'),
                    'ma' => (float) $assessment->convertMinatToNumeric($assessment->minat_a ?? ''),
                    'mb' => (float) $assessment->convertMinatToNumeric($assessment->minat_b ?? ''),
                    'mc' => (float) $assessment->convertMinatToNumeric($assessment->minat_c ?? ''),
                    'md' => (float) $assessment->convertMinatToNumeric($assessment->minat_d ?? ''),
                    'bb' => (float) $assessment->convertKeahlianToNumeric($assessment->keahlian ?? ''),
                    'bp' => (float) $assessment->convertBiayaGelombangToNumeric($assessment->biaya_gelombang ?? ''),
               ];

               // PERBAIKAN: Kode anomali untuk Balqisy TELAH DIHAPUS.
               // Perhitungan sekarang murni berdasarkan aturan di atas.

               $matrix[] = $row;
          }
          return $matrix;
     }

     private function isAssessmentValid($assessment): bool
     {
          $requiredFields = ['nilai_ipa', 'nilai_ips', 'nilai_matematika', 'nilai_bahasa_indonesia', 'nilai_bahasa_inggris', 'nilai_pkn', 'minat_a', 'minat_b', 'minat_c', 'minat_d', 'keahlian', 'biaya_gelombang'];
          foreach ($requiredFields as $field) {
               if (empty($assessment->$field)) return false;
          }
          return true;
     }

     public function calculateTopsis($penilaianId = null): Collection
     {
          try {
               DB::beginTransaction();

               $query = PenilaianPesertaDidik::with('pesertaDidik');
               if ($penilaianId) {
                    $query->where('penilaian_id', $penilaianId);
               } else {
                    $query->where('sudah_dihitung', false);
               }
               $targetAssessments = $query->get();

               if ($targetAssessments->isEmpty()) {
                    DB::rollback();
                    return collect();
               }

               $tahunAjaran = $targetAssessments->first()->tahun_ajaran;

               $allAssessmentsForNormalization = PenilaianPesertaDidik::with('pesertaDidik')
                    ->where('tahun_ajaran', $tahunAjaran)
                    ->readyForCalculation()
                    ->get();

               if (!$allAssessmentsForNormalization->contains('penilaian_id', $penilaianId)) {
                    $allAssessmentsForNormalization = $allAssessmentsForNormalization->concat($targetAssessments);
               }

               $decisionMatrix = $this->buildDecisionMatrix($allAssessmentsForNormalization);
               if (empty($decisionMatrix)) throw new Exception('Matriks keputusan kosong');

               $normalizedMatrix = $this->normalizeMatrix($decisionMatrix);
               $weightedMatrix = $this->calculateWeightedMatrix($normalizedMatrix);
               $idealSolutions = $this->calculateIdealSolutions($weightedMatrix);
               $results = $this->calculatePreferenceScores($weightedMatrix, $idealSolutions, $allAssessmentsForNormalization);

               $this->saveResults($results, $normalizedMatrix, $weightedMatrix, $targetAssessments);

               DB::commit();

               return $results->whereIn('penilaian_id', $targetAssessments->pluck('penilaian_id'));
          } catch (Exception $e) {
               DB::rollback();
               Log::error('Perhitungan TOPSIS gagal', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
               throw new Exception('Perhitungan TOPSIS gagal: ' . $e->getMessage());
          }
     }

     private function normalizeMatrix(array $decisionMatrix): array
     {
          $normalizedMatrix = [];
          $criteriaKeys = array_keys($this->weights);
          $sumSquares = [];

          foreach ($criteriaKeys as $criteria) {
               $sumSquares[$criteria] = 0;
               foreach ($decisionMatrix as $row) {
                    $sumSquares[$criteria] += pow($row[$criteria] ?? 0, 2);
               }
               $sumSquares[$criteria] = sqrt($sumSquares[$criteria]);
          }

          foreach ($decisionMatrix as $row) {
               $normalizedRow = $row;
               foreach ($criteriaKeys as $criteria) {
                    $value = $row[$criteria] ?? 0;
                    $sumSquare = $sumSquares[$criteria] ?? 1;
                    $normalizedRow[$criteria] = $sumSquare == 0 ? 0 : $value / $sumSquare;
               }
               $normalizedMatrix[] = $normalizedRow;
          }
          return $normalizedMatrix;
     }

     private function calculateWeightedMatrix(array $normalizedMatrix): array
     {
          $weightedMatrix = [];
          $criteriaKeys = array_keys($this->weights);
          foreach ($normalizedMatrix as $row) {
               $weightedRow = $row;
               foreach ($criteriaKeys as $criteria) {
                    $weightedRow[$criteria] = ($row[$criteria] ?? 0) * ($this->weights[$criteria] ?? 0);
               }
               $weightedMatrix[] = $weightedRow;
          }
          return $weightedMatrix;
     }

     private function calculateIdealSolutions(array $weightedMatrix): array
     {
          $criteriaKeys = array_keys($this->weights);
          $idealPositive = [];
          $idealNegative = [];

          foreach ($criteriaKeys as $criteria) {
               $values = array_column($weightedMatrix, $criteria);
               if (empty($values)) {
                    $idealPositive[$criteria] = 0;
                    $idealNegative[$criteria] = 0;
                    continue;
               }
               // 'bp' adalah satu-satunya kriteria COST
               if ($this->criteria->where('kode_kriteria', strtoupper($criteria))->first()->atribut === 'Cost') {
                    $idealPositive[$criteria] = min($values);
                    $idealNegative[$criteria] = max($values);
               } else { // Sisanya BENEFIT
                    $idealPositive[$criteria] = max($values);
                    $idealNegative[$criteria] = min($values);
               }
          }
          return ['positive' => $idealPositive, 'negative' => $idealNegative];
     }

     private function calculatePreferenceScores(array $weightedMatrix, array $idealSolutions, Collection $assessments): Collection
     {
          $results = collect();
          $criteriaKeys = array_keys($this->weights);

          foreach ($weightedMatrix as $row) {
               $distancePositive = 0;
               $distanceNegative = 0;

               foreach ($criteriaKeys as $criteria) {
                    $value = $row[$criteria] ?? 0;
                    $distancePositive += pow($value - ($idealSolutions['positive'][$criteria] ?? 0), 2);
                    $distanceNegative += pow($value - ($idealSolutions['negative'][$criteria] ?? 0), 2);
               }

               $distancePositive = sqrt($distancePositive);
               $distanceNegative = sqrt($distanceNegative);
               $totalDistance = $distancePositive + $distanceNegative;

               $preferenceScore = $totalDistance == 0 ? 0 : $distanceNegative / $totalDistance;

               $results->push([
                    'penilaian_id' => $row['penilaian_id'],
                    'peserta_didik_id' => $row['peserta_didik_id'],
                    'tahun_ajaran' => $row['tahun_ajaran'],
                    'distance_positive' => $distancePositive,
                    'distance_negative' => $distanceNegative,
                    'preference_score' => $preferenceScore,
                    'recommendation' => $preferenceScore > 0.30 ? 'TKJ' : 'TKR', // Sesuai catatan Excel
                    'assessment' => $assessments->where('penilaian_id', $row['penilaian_id'])->first()
               ]);
          }
          return $results->sortByDesc('preference_score')->values();
     }

     private function saveResults(Collection $results, array $normalizedMatrix, array $weightedMatrix, Collection $targetAssessments): void
     {
          $normalizedMatrixMap = collect($normalizedMatrix)->keyBy('penilaian_id');
          $weightedMatrixMap = collect($weightedMatrix)->keyBy('penilaian_id');

          foreach ($results as $result) {
               // Hanya simpan hasil untuk siswa target
               if (!$targetAssessments->contains('penilaian_id', $result['penilaian_id'])) continue;

               $normalized = $normalizedMatrixMap->get($result['penilaian_id']) ?? [];
               $weighted = $weightedMatrixMap->get($result['penilaian_id']) ?? [];

               PerhitunganTopsis::updateOrCreate(
                    ['peserta_didik_id' => $result['peserta_didik_id'], 'penilaian_id' => $result['penilaian_id']],
                    [
                         'tahun_ajaran' => $result['tahun_ajaran'],
                         'normalized_n1' => $normalized['n1'] ?? 0,
                         'normalized_n2' => $normalized['n2'] ?? 0,
                         'normalized_n3' => $normalized['n3'] ?? 0,
                         'normalized_n4' => $normalized['n4'] ?? 0,
                         'normalized_n5' => $normalized['n5'] ?? 0,
                         'normalized_n6' => $normalized['n6'] ?? 0,
                         'normalized_ma' => $normalized['ma'] ?? 0,
                         'normalized_mb' => $normalized['mb'] ?? 0,
                         'normalized_mc' => $normalized['mc'] ?? 0,
                         'normalized_md' => $normalized['md'] ?? 0,
                         'normalized_bb' => $normalized['bb'] ?? 0,
                         'normalized_bp' => $normalized['bp'] ?? 0,
                         'weighted_n1' => $weighted['n1'] ?? 0,
                         'weighted_n2' => $weighted['n2'] ?? 0,
                         'weighted_n3' => $weighted['n3'] ?? 0,
                         'weighted_n4' => $weighted['n4'] ?? 0,
                         'weighted_n5' => $weighted['n5'] ?? 0,
                         'weighted_n6' => $weighted['n6'] ?? 0,
                         'weighted_ma' => $weighted['ma'] ?? 0,
                         'weighted_mb' => $weighted['mb'] ?? 0,
                         'weighted_mc' => $weighted['mc'] ?? 0,
                         'weighted_md' => $weighted['md'] ?? 0,
                         'weighted_bb' => $weighted['bb'] ?? 0,
                         'weighted_bp' => $weighted['bp'] ?? 0,
                         'jarak_positif' => $result['distance_positive'],
                         'jarak_negatif' => $result['distance_negative'],
                         'nilai_preferensi' => $result['preference_score'],
                         'jurusan_rekomendasi' => $result['recommendation'],
                         'tanggal_perhitungan' => now()
                    ]
               );

               if ($result['assessment']) {
                    $result['assessment']->update(['sudah_dihitung' => true]);
               }
          }
     }

     /**
      * Bobot kriteria sesuai dengan file Excel.
      */
     private function getCriteriaWeights(): array
     {
          return [
               'n1' => 0.02,
               'n2' => 0.02,
               'n3' => 0.02,
               'n4' => 0.02,
               'n5' => 0.02,
               'n6' => 0.02,
               'ma' => 0.03,
               'mb' => 0.39,
               'mc' => 0.03,
               'md' => 0.03,
               'bb' => 0.39,
               'bp' => 0.01
          ];
     }

     public function getCalculationStatistics(string $tahunAjaran = null): array
     {
          $query = PerhitunganTopsis::with('pesertaDidik');
          if ($tahunAjaran) {
               $query->where('tahun_ajaran', $tahunAjaran);
          }
          $calculations = $query->get();
          return [
               'total_calculations' => $calculations->count(),
               'tkj_recommendations' => $calculations->where('jurusan_rekomendasi', 'TKJ')->count(),
               'tkr_recommendations' => $calculations->where('jurusan_rekomendasi', 'TKR')->count(),
               'average_preference_score' => $calculations->avg('nilai_preferensi') ?? 0,
               'highest_preference_score' => $calculations->max('nilai_preferensi') ?? 0,
               'lowest_preference_score' => $calculations->min('nilai_preferensi') ?? 0,
          ];
     }

     public function validateWeights(): bool
     {
          return abs(array_sum($this->weights) - 1.0) < 0.001;
     }

     public function getCriteriaInfo(): array
     {
          return [
               'criteria' => $this->criteria->toArray(),
               'weights' => $this->weights,
               'total_weight' => array_sum($this->weights),
               'is_valid' => $this->validateWeights()
          ];
     }
}
