<?php
// app/Services/TopsisCalculationService.php

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
      * Calculate TOPSIS - KONSISTEN DENGAN EXCEL
      * Menggunakan SEMUA data untuk normalisasi
      */
     public function calculateTopsis($penilaianId = null): Collection
     {
          try {
               DB::beginTransaction();

               // Target assessments yang akan dihitung
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

               // KUNCI: Ambil SEMUA data untuk normalisasi yang konsisten
               $allAssessments = PenilaianPesertaDidik::with('pesertaDidik')
                    ->where('tahun_ajaran', $tahunAjaran)
                    ->readyForCalculation()
                    ->get();

               // Pastikan target ada dalam allAssessments
               foreach ($targetAssessments as $target) {
                    if (!$allAssessments->contains('penilaian_id', $target->penilaian_id)) {
                         $allAssessments->push($target);
                    }
               }

               Log::info('TOPSIS Started', [
                    'target_count' => $targetAssessments->count(),
                    'all_count' => $allAssessments->count(),
                    'tahun_ajaran' => $tahunAjaran
               ]);

               // Build decision matrix
               $decisionMatrix = $this->buildDecisionMatrix($allAssessments);
               if (empty($decisionMatrix)) {
                    throw new Exception('Decision matrix is empty');
               }

               // Normalisasi
               $normalizedMatrix = $this->normalizeMatrix($decisionMatrix);

               // Weighted
               $weightedMatrix = $this->calculateWeightedMatrix($normalizedMatrix);

               // Ideal solutions
               $idealSolutions = $this->calculateIdealSolutions($weightedMatrix);

               // Preference scores
               $results = $this->calculatePreferenceScores($weightedMatrix, $idealSolutions, $allAssessments);

               // Save ONLY target assessments
               $this->saveResults($results, $normalizedMatrix, $weightedMatrix, $targetAssessments);

               DB::commit();

               Log::info('TOPSIS Completed', [
                    'results_count' => $results->count()
               ]);

               // Return ONLY target results
               return $results->whereIn('penilaian_id', $targetAssessments->pluck('penilaian_id'));
          } catch (Exception $e) {
               DB::rollback();
               Log::error('TOPSIS Failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
               ]);
               throw new Exception('TOPSIS calculation failed: ' . $e->getMessage());
          }
     }

     /**
      * Build decision matrix
      */
     private function buildDecisionMatrix(Collection $assessments): array
     {
          $matrix = [];
          foreach ($assessments as $assessment) {
               if (!$this->isAssessmentValid($assessment)) {
                    Log::warning('Invalid assessment skipped', [
                         'penilaian_id' => $assessment->penilaian_id
                    ]);
                    continue;
               }

               $row = [
                    'penilaian_id' => $assessment->penilaian_id,
                    'peserta_didik_id' => $assessment->peserta_didik_id,
                    'tahun_ajaran' => $assessment->tahun_ajaran,
                    'n1' => (float)$assessment->convertNilaiToBobot($assessment->nilai_ipa),
                    'n2' => (float)$assessment->convertNilaiToBobot($assessment->nilai_ips),
                    'n3' => (float)$assessment->convertNilaiToBobot($assessment->nilai_bahasa_inggris),
                    'n4' => (float)$assessment->convertNilaiToBobot($assessment->nilai_matematika),
                    'n5' => (float)$assessment->convertNilaiToBobot($assessment->nilai_bahasa_indonesia),
                    'n6' => (float)$assessment->convertNilaiToBobot($assessment->nilai_pkn),
                    'ma' => (float)$assessment->convertMinatToNumeric($assessment->minat_a ?? ''),
                    'mb' => (float)$assessment->convertMinatToNumeric($assessment->minat_b ?? ''),
                    'mc' => (float)$assessment->convertMinatToNumeric($assessment->minat_c ?? ''),
                    'md' => (float)$assessment->convertMinatToNumeric($assessment->minat_d ?? ''),
                    'bb' => (float)$assessment->convertKeahlianToNumeric($assessment->keahlian ?? ''),
                    'bp' => (float)$assessment->convertBiayaGelombangToNumeric($assessment->biaya_gelombang ?? ''),
               ];

               $matrix[] = $row;
          }
          return $matrix;
     }

     /**
      * Validate assessment
      */
     private function isAssessmentValid($assessment): bool
     {
          $requiredFields = [
               'nilai_ipa',
               'nilai_ips',
               'nilai_matematika',
               'nilai_bahasa_indonesia',
               'nilai_bahasa_inggris',
               'nilai_pkn',
               'minat_a',
               'minat_b',
               'minat_c',
               'minat_d',
               'keahlian',
               'biaya_gelombang'
          ];

          foreach ($requiredFields as $field) {
               if (empty($assessment->$field)) {
                    return false;
               }
          }
          return true;
     }

     /**
      * Normalize matrix using Euclidean method
      */
     private function normalizeMatrix(array $decisionMatrix): array
     {
          $normalizedMatrix = [];
          $criteriaKeys = ['n1', 'n2', 'n3', 'n4', 'n5', 'n6', 'ma', 'mb', 'mc', 'md', 'bb', 'bp'];

          // Calculate sum of squares
          $sumSquares = [];
          foreach ($criteriaKeys as $criteria) {
               $sumSquares[$criteria] = 0;
               foreach ($decisionMatrix as $row) {
                    $sumSquares[$criteria] += pow($row[$criteria] ?? 0, 2);
               }
               $sumSquares[$criteria] = sqrt($sumSquares[$criteria]);
          }

          // Normalize each value
          foreach ($decisionMatrix as $row) {
               $normalizedRow = [
                    'penilaian_id' => $row['penilaian_id'],
                    'peserta_didik_id' => $row['peserta_didik_id'],
                    'tahun_ajaran' => $row['tahun_ajaran']
               ];

               foreach ($criteriaKeys as $criteria) {
                    $value = $row[$criteria] ?? 0;
                    $sumSquare = $sumSquares[$criteria] ?? 1;
                    $normalizedRow[$criteria] = $sumSquare == 0 ? 0 : $value / $sumSquare;
               }

               $normalizedMatrix[] = $normalizedRow;
          }

          return $normalizedMatrix;
     }

     /**
      * Calculate weighted matrix
      */
     private function calculateWeightedMatrix(array $normalizedMatrix): array
     {
          $weightedMatrix = [];
          $criteriaKeys = ['n1', 'n2', 'n3', 'n4', 'n5', 'n6', 'ma', 'mb', 'mc', 'md', 'bb', 'bp'];

          foreach ($normalizedMatrix as $row) {
               $weightedRow = [
                    'penilaian_id' => $row['penilaian_id'],
                    'peserta_didik_id' => $row['peserta_didik_id'],
                    'tahun_ajaran' => $row['tahun_ajaran']
               ];

               foreach ($criteriaKeys as $criteria) {
                    $weightedRow[$criteria] = ($row[$criteria] ?? 0) * ($this->weights[$criteria] ?? 0);
               }

               $weightedMatrix[] = $weightedRow;
          }

          return $weightedMatrix;
     }

     /**
      * Calculate ideal solutions
      */
     private function calculateIdealSolutions(array $weightedMatrix): array
     {
          $criteriaKeys = ['n1', 'n2', 'n3', 'n4', 'n5', 'n6', 'ma', 'mb', 'mc', 'md', 'bb', 'bp'];
          $idealPositive = [];
          $idealNegative = [];

          foreach ($criteriaKeys as $criteria) {
               $values = array_column($weightedMatrix, $criteria);

               if (empty($values)) {
                    $idealPositive[$criteria] = 0;
                    $idealNegative[$criteria] = 0;
                    continue;
               }

               // BP = COST (lower is better)
               if ($criteria === 'bp') {
                    $idealPositive[$criteria] = min($values);
                    $idealNegative[$criteria] = max($values);
               } else {
                    // Others = BENEFIT (higher is better)
                    $idealPositive[$criteria] = max($values);
                    $idealNegative[$criteria] = min($values);
               }
          }

          return [
               'positive' => $idealPositive,
               'negative' => $idealNegative
          ];
     }

     /**
      * Calculate preference scores
      */
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

               $recommendation = $preferenceScore > 0.30 ? 'TKJ' : 'TKR';

               $assessment = $assessments->where('penilaian_id', $row['penilaian_id'])->first();

               $results->push([
                    'penilaian_id' => $row['penilaian_id'],
                    'peserta_didik_id' => $row['peserta_didik_id'],
                    'tahun_ajaran' => $row['tahun_ajaran'],
                    'distance_positive' => $distancePositive,
                    'distance_negative' => $distanceNegative,
                    'preference_score' => $preferenceScore,
                    'recommendation' => $recommendation,
                    'assessment' => $assessment
               ]);
          }

          return $results->sortByDesc('preference_score')->values();
     }

     /**
      * Save results to database
      */
     private function saveResults(Collection $results, array $normalizedMatrix, array $weightedMatrix, Collection $targetAssessments): void
     {
          $normalizedMatrixMap = collect($normalizedMatrix)->keyBy('penilaian_id');
          $weightedMatrixMap = collect($weightedMatrix)->keyBy('penilaian_id');

          foreach ($results as $result) {
               // Save ONLY target assessments
               if (!$targetAssessments->where('penilaian_id', $result['penilaian_id'])->first()) {
                    continue;
               }

               $normalized = $normalizedMatrixMap->get($result['penilaian_id']) ?? [];
               $weighted = $weightedMatrixMap->get($result['penilaian_id']) ?? [];

               PerhitunganTopsis::updateOrCreate(
                    [
                         'peserta_didik_id' => $result['peserta_didik_id'],
                         'penilaian_id' => $result['penilaian_id']
                    ],
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
      * Get criteria weights - SESUAI EXCEL
      */
     private function getCriteriaWeights(): array
     {
          return [
               'n1' => 0.02,  // 2%
               'n2' => 0.02,  // 2%
               'n3' => 0.02,  // 2%
               'n4' => 0.02,  // 2%
               'n5' => 0.02,  // 2%
               'n6' => 0.02,  // 2%
               'ma' => 0.03,  // 3%
               'mb' => 0.39,  // 39% - TERBESAR
               'mc' => 0.03,  // 3%
               'md' => 0.03,  // 3%
               'bb' => 0.39,  // 39% - TERBESAR
               'bp' => 0.01   // 1% - COST
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
}
