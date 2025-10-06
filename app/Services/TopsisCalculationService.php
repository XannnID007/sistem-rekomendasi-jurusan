<?php

namespace App\Services;

use Exception;
use App\Models\Kriteria;
use App\Models\PerhitunganTopsis;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\PenilaianPesertaDidik;

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
      * Build decision matrix from assessments
      */
     private function buildDecisionMatrix(Collection $assessments): array
     {
          $matrix = [];

          foreach ($assessments as $assessment) {
               if (!$this->isAssessmentValid($assessment)) {
                    Log::warning('Invalid assessment data', [
                         'penilaian_id' => $assessment->penilaian_id,
                         'missing_fields' => $assessment->getMissingFields()
                    ]);
                    continue;
               }

               $row = [
                    'penilaian_id' => $assessment->penilaian_id,
                    'peserta_didik_id' => $assessment->peserta_didik_id,
                    'tahun_ajaran' => $assessment->tahun_ajaran,
                    // Sesuai urutan di Excel
                    'n1' => (float) $assessment->nilai_ipa,
                    'n2' => (float) $assessment->nilai_ips,
                    'n3' => (float) $assessment->nilai_bahasa_inggris, // SESUAI EXCEL
                    'n4' => (float) $assessment->nilai_matematika,
                    'n5' => (float) $assessment->nilai_bahasa_indonesia,
                    'n6' => (float) $assessment->nilai_pkn,
                    'ma' => (float) $assessment->convertMinatToNumeric($assessment->minat_a ?? ''),
                    'mb' => (float) $assessment->convertMinatToNumeric($assessment->minat_b ?? ''),
                    'mc' => (float) $assessment->convertMinatToNumeric($assessment->minat_c ?? ''),
                    'md' => (float) $assessment->convertMinatToNumeric($assessment->minat_d ?? ''),
                    'bb' => (float) $assessment->convertKeahlianToNumeric($assessment->keahlian ?? ''),
                    'bp' => (float) $assessment->convertBiayaGelombangToNumeric($assessment->biaya_gelombang ?? ''),
               ];

               Log::info("Decision Matrix Row for {$assessment->pesertaDidik->nama_lengkap}", $row);

               $matrix[] = $row;
          }

          return $matrix;
     }

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
               'biaya_gelombang' // CHANGED
          ];

          foreach ($requiredFields as $field) {
               if (empty($assessment->$field)) {
                    return false;
               }
          }
          return true;
     }

     /**
      * Calculate TOPSIS
      */
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

               $assessments = $query->get();

               if ($assessments->isEmpty()) {
                    DB::rollback();
                    return collect();
               }

               $tahunAjaran = $assessments->first()->tahun_ajaran;
               $allAssessments = PenilaianPesertaDidik::with('pesertaDidik')
                    ->where('tahun_ajaran', $tahunAjaran)
                    ->readyForCalculation()
                    ->get();

               Log::info('TOPSIS Calculation Start', [
                    'requested_assessments' => $assessments->count(),
                    'all_assessments' => $allAssessments->count(),
                    'academic_year' => $tahunAjaran
               ]);

               // Step 1: Build decision matrix
               $decisionMatrix = $this->buildDecisionMatrix($allAssessments);

               if (empty($decisionMatrix)) {
                    throw new Exception('Decision matrix is empty');
               }

               // Step 2: Normalize matrix
               $normalizedMatrix = $this->normalizeMatrix($decisionMatrix);

               // Step 3: Calculate weighted normalized matrix
               $weightedMatrix = $this->calculateWeightedMatrix($normalizedMatrix);

               // Step 4: Determine ideal solutions
               $idealSolutions = $this->calculateIdealSolutions($weightedMatrix);

               // Step 5: Calculate distances and preference scores
               $results = $this->calculatePreferenceScores($weightedMatrix, $idealSolutions, $allAssessments);

               // Step 6: Save results
               $this->saveResults($results, $normalizedMatrix, $weightedMatrix, $assessments);

               DB::commit();

               if ($penilaianId) {
                    return $results->where('penilaian_id', $penilaianId);
               }

               return $results->whereIn('penilaian_id', $assessments->pluck('penilaian_id'));
          } catch (Exception $e) {
               DB::rollback();
               Log::error('TOPSIS calculation failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
               ]);
               throw new Exception('TOPSIS calculation failed: ' . $e->getMessage());
          }
     }

     /**
      * Normalize matrix using standard euclidean normalization
      */
     private function normalizeMatrix(array $decisionMatrix): array
     {
          $normalizedMatrix = [];
          $criteriaKeys = ['n1', 'n2', 'n3', 'n4', 'n5', 'n6', 'ma', 'mb', 'mc', 'md', 'bb', 'bp'];

          // Calculate sum of squares for each criterion
          $sumSquares = [];
          foreach ($criteriaKeys as $criteria) {
               $sumSquares[$criteria] = 0;
               foreach ($decisionMatrix as $row) {
                    $sumSquares[$criteria] += pow($row[$criteria] ?? 0, 2);
               }
               $sumSquares[$criteria] = sqrt($sumSquares[$criteria]);
          }

          Log::info('Sum of squares for normalization', $sumSquares);

          // Normalize each value
          foreach ($decisionMatrix as $index => $row) {
               $normalizedRow = [
                    'penilaian_id' => $row['penilaian_id'],
                    'peserta_didik_id' => $row['peserta_didik_id'],
                    'tahun_ajaran' => $row['tahun_ajaran']
               ];

               foreach ($criteriaKeys as $criteria) {
                    $value = $row[$criteria] ?? 0;
                    $sumSquare = $sumSquares[$criteria] ?? 1;
                    $normalizedValue = $sumSquare == 0 ? 0 : $value / $sumSquare;
                    $normalizedRow[$criteria] = $normalizedValue;
               }

               $normalizedMatrix[$index] = $normalizedRow;
          }

          return $normalizedMatrix;
     }

     /**
      * Calculate weighted normalized matrix
      */
     private function calculateWeightedMatrix(array $normalizedMatrix): array
     {
          $weightedMatrix = [];
          $criteriaKeys = ['n1', 'n2', 'n3', 'n4', 'n5', 'n6', 'ma', 'mb', 'mc', 'md', 'bb', 'bp'];

          foreach ($normalizedMatrix as $index => $row) {
               $weightedRow = [
                    'penilaian_id' => $row['penilaian_id'],
                    'peserta_didik_id' => $row['peserta_didik_id'],
                    'tahun_ajaran' => $row['tahun_ajaran']
               ];

               foreach ($criteriaKeys as $criteria) {
                    $normalizedValue = $row[$criteria] ?? 0;
                    $weight = $this->weights[$criteria] ?? 0;
                    $weightedRow[$criteria] = $normalizedValue * $weight;
               }

               $weightedMatrix[$index] = $weightedRow;
          }

          return $weightedMatrix;
     }

     /**
      * Calculate ideal positive and negative solutions
      * PENTING: BP adalah COST (semakin rendah semakin baik)
      */
     private function calculateIdealSolutions(array $weightedMatrix): array
     {
          $criteriaKeys = ['n1', 'n2', 'n3', 'n4', 'n5', 'n6', 'ma', 'mb', 'mc', 'md', 'bb', 'bp'];
          $idealPositive = [];
          $idealNegative = [];

          foreach ($criteriaKeys as $criteria) {
               $values = [];
               foreach ($weightedMatrix as $row) {
                    $values[] = $row[$criteria] ?? 0;
               }

               if (empty($values)) {
                    $idealPositive[$criteria] = 0;
                    $idealNegative[$criteria] = 0;
                    continue;
               }

               // BP adalah COST, sisanya BENEFIT
               if ($criteria === 'bp') {
                    // COST: ideal positif = min, ideal negatif = max
                    $idealPositive[$criteria] = min($values);
                    $idealNegative[$criteria] = max($values);
               } else {
                    // BENEFIT: ideal positif = max, ideal negatif = min
                    $idealPositive[$criteria] = max($values);
                    $idealNegative[$criteria] = min($values);
               }
          }

          Log::info('Ideal Solutions', [
               'positive' => $idealPositive,
               'negative' => $idealNegative
          ]);

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
          $criteriaKeys = ['n1', 'n2', 'n3', 'n4', 'n5', 'n6', 'ma', 'mb', 'mc', 'md', 'bb', 'bp'];

          foreach ($weightedMatrix as $index => $row) {
               $assessment = $assessments->where('penilaian_id', $row['penilaian_id'])->first();

               // Calculate distance to positive ideal
               $distancePositive = 0;
               foreach ($criteriaKeys as $criteria) {
                    $value = $row[$criteria] ?? 0;
                    $idealPos = $idealSolutions['positive'][$criteria] ?? 0;
                    $distancePositive += pow($value - $idealPos, 2);
               }
               $distancePositive = sqrt($distancePositive);

               // Calculate distance to negative ideal
               $distanceNegative = 0;
               foreach ($criteriaKeys as $criteria) {
                    $value = $row[$criteria] ?? 0;
                    $idealNeg = $idealSolutions['negative'][$criteria] ?? 0;
                    $distanceNegative += pow($value - $idealNeg, 2);
               }
               $distanceNegative = sqrt($distanceNegative);

               // Calculate preference score
               $totalDistance = $distancePositive + $distanceNegative;
               $preferenceScore = $totalDistance == 0 ? 0.5 : $distanceNegative / $totalDistance;

               // Determine recommendation based on threshold
               $recommendation = $preferenceScore > 0.30 ? 'TKJ' : 'TKR';

               Log::info('Preference score calculated', [
                    'nama' => $assessment->pesertaDidik->nama_lengkap ?? 'Unknown',
                    'penilaian_id' => $row['penilaian_id'],
                    'distance_positive' => $distancePositive,
                    'distance_negative' => $distanceNegative,
                    'preference_score' => $preferenceScore,
                    'recommendation' => $recommendation
               ]);

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
      * Save calculation results to database
      */
     private function saveResults(Collection $results, array $normalizedMatrix, array $weightedMatrix, Collection $targetAssessments): void
     {
          foreach ($results as $index => $result) {
               if (!$targetAssessments->where('penilaian_id', $result['penilaian_id'])->first()) {
                    continue;
               }

               $normalized = $normalizedMatrix[$index] ?? [];
               $weighted = $weightedMatrix[$index] ?? [];

               try {
                    PerhitunganTopsis::updateOrCreate(
                         [
                              'peserta_didik_id' => $result['peserta_didik_id'],
                              'penilaian_id' => $result['penilaian_id'],
                              'tahun_ajaran' => $result['tahun_ajaran']
                         ],
                         [
                              // Normalized values
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

                              // Weighted values
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

                              // Results
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
               } catch (Exception $e) {
                    Log::error('Failed to save TOPSIS result', [
                         'penilaian_id' => $result['penilaian_id'],
                         'error' => $e->getMessage()
                    ]);
               }
          }
     }

     /**
      * Get criteria weights SESUAI EXCEL
      */
     private function getCriteriaWeights(): array
     {
          $weights = [];
          $criteriaMapping = [
               'N1' => 'n1',
               'N2' => 'n2',
               'N3' => 'n3',
               'N4' => 'n4',
               'N5' => 'n5',
               'N6' => 'n6',
               'MA' => 'ma',
               'MB' => 'mb',
               'MC' => 'mc',
               'MD' => 'md',
               'BB' => 'bb',
               'BP' => 'bp'
          ];

          foreach ($this->criteria as $criteria) {
               $key = $criteriaMapping[$criteria->kode_kriteria] ?? null;
               if ($key) {
                    $weights[$key] = (float) $criteria->bobot;
               }
          }

          // Default weights SESUAI EXCEL
          $defaultWeights = [
               'n1' => 0.0200, // 2%
               'n2' => 0.0200, // 2%
               'n3' => 0.0200, // 2%
               'n4' => 0.0200, // 2%
               'n5' => 0.0200, // 2%
               'n6' => 0.0200, // 2%
               'ma' => 0.0300, // 3%
               'mb' => 0.3900, // 39% - TERBESAR!
               'mc' => 0.0300, // 3%
               'md' => 0.0300, // 3%
               'bb' => 0.3900, // 39% - TERBESAR!
               'bp' => 0.0100  // 1% - COST
          ];

          foreach ($defaultWeights as $key => $defaultWeight) {
               if (!isset($weights[$key])) {
                    $weights[$key] = $defaultWeight;
               }
          }

          return $weights;
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
          $totalWeight = array_sum($this->weights);
          return abs($totalWeight - 1.0) < 0.001;
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
