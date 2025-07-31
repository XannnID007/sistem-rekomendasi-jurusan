<?php

namespace App\Services;

use App\Models\PenilaianPesertaDidik;
use App\Models\PerhitunganTopsis;
use App\Models\Kriteria;
use Illuminate\Support\Collection;

class TopsisCalculationService
{
     private Collection $criteria;
     private array $weights;

     public function __construct()
     {
          $this->criteria = Kriteria::active()->get();
          $this->weights = $this->getCriteriaWeights();
     }

     /**
      * Calculate TOPSIS for all assessments or specific assessment
      */
     public function calculateTopsis($penilaianId = null): Collection
     {
          $query = PenilaianPesertaDidik::with('pesertaDidik');

          if ($penilaianId) {
               $query->where('penilaian_id', $penilaianId);
          }

          $assessments = $query->get();

          if ($assessments->isEmpty()) {
               return collect();
          }

          // Step 1: Build decision matrix
          $decisionMatrix = $this->buildDecisionMatrix($assessments);

          // Step 2: Normalize decision matrix
          $normalizedMatrix = $this->normalizeMatrix($decisionMatrix);

          // Step 3: Calculate weighted normalized matrix
          $weightedMatrix = $this->calculateWeightedMatrix($normalizedMatrix);

          // Step 4: Determine ideal solutions
          $idealSolutions = $this->calculateIdealSolutions($weightedMatrix);

          // Step 5: Calculate distances and preference scores
          $results = $this->calculatePreferenceScores($weightedMatrix, $idealSolutions, $assessments);

          // Step 6: Save results to database
          $this->saveResults($results, $normalizedMatrix, $weightedMatrix);

          return $results;
     }

     /**
      * Build decision matrix from assessments
      */
     private function buildDecisionMatrix(Collection $assessments): array
     {
          $matrix = [];

          foreach ($assessments as $index => $assessment) {
               $row = [
                    'penilaian_id' => $assessment->penilaian_id,
                    'peserta_didik_id' => $assessment->peserta_didik_id,
                    'n1' => $assessment->nilai_ipa,
                    'n2' => $assessment->nilai_ips,
                    'n3' => $assessment->nilai_matematika,
                    'n4' => $assessment->nilai_bahasa_indonesia,
                    'n5' => $assessment->nilai_bahasa_inggris,
                    'n6' => $assessment->nilai_produktif,
                    'ma' => $assessment->convertMinatToNumeric($assessment->minat_a),
                    'mb' => $assessment->convertMinatToNumeric($assessment->minat_b),
                    'mc' => $assessment->convertMinatToNumeric($assessment->minat_c),
                    'md' => $assessment->convertMinatToNumeric($assessment->minat_d),
                    'bb' => $assessment->convertKeahlianToNumeric($assessment->keahlian),
                    'bp' => $assessment->convertPenghasilanToNumeric($assessment->penghasilan_ortu),
               ];

               $matrix[$index] = $row;
          }

          return $matrix;
     }

     /**
      * Normalize decision matrix using euclidean normalization
      */
     private function normalizeMatrix(array $decisionMatrix): array
     {
          $normalizedMatrix = [];
          $criteriaKeys = ['n1', 'n2', 'n3', 'n4', 'n5', 'n6', 'ma', 'mb', 'mc', 'md', 'bb', 'bp'];

          // Calculate sum of squares for each criteria
          $sumOfSquares = [];
          foreach ($criteriaKeys as $criteria) {
               $sumOfSquares[$criteria] = 0;
               foreach ($decisionMatrix as $row) {
                    $sumOfSquares[$criteria] += pow($row[$criteria], 2);
               }
               $sumOfSquares[$criteria] = sqrt($sumOfSquares[$criteria]);
          }

          // Normalize each element
          foreach ($decisionMatrix as $index => $row) {
               $normalizedRow = [
                    'penilaian_id' => $row['penilaian_id'],
                    'peserta_didik_id' => $row['peserta_didik_id']
               ];

               foreach ($criteriaKeys as $criteria) {
                    $normalizedRow[$criteria] = $sumOfSquares[$criteria] > 0
                         ? $row[$criteria] / $sumOfSquares[$criteria]
                         : 0;
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
                    'peserta_didik_id' => $row['peserta_didik_id']
               ];

               foreach ($criteriaKeys as $criteria) {
                    $weightedRow[$criteria] = $row[$criteria] * $this->weights[$criteria];
               }

               $weightedMatrix[$index] = $weightedRow;
          }

          return $weightedMatrix;
     }

     /**
      * Calculate ideal positive and negative solutions
      */
     private function calculateIdealSolutions(array $weightedMatrix): array
     {
          $criteriaKeys = ['n1', 'n2', 'n3', 'n4', 'n5', 'n6', 'ma', 'mb', 'mc', 'md', 'bb', 'bp'];
          $idealPositive = [];
          $idealNegative = [];

          foreach ($criteriaKeys as $criteria) {
               $values = array_column($weightedMatrix, $criteria);

               // All criteria are benefit type in our case
               // For benefit: ideal positive = max, ideal negative = min
               $idealPositive[$criteria] = max($values);
               $idealNegative[$criteria] = min($values);
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
          $criteriaKeys = ['n1', 'n2', 'n3', 'n4', 'n5', 'n6', 'ma', 'mb', 'mc', 'md', 'bb', 'bp'];

          foreach ($weightedMatrix as $index => $row) {
               // Calculate distance to ideal positive
               $distancePositive = 0;
               foreach ($criteriaKeys as $criteria) {
                    $distancePositive += pow($row[$criteria] - $idealSolutions['positive'][$criteria], 2);
               }
               $distancePositive = sqrt($distancePositive);

               // Calculate distance to ideal negative
               $distanceNegative = 0;
               foreach ($criteriaKeys as $criteria) {
                    $distanceNegative += pow($row[$criteria] - $idealSolutions['negative'][$criteria], 2);
               }
               $distanceNegative = sqrt($distanceNegative);

               // Calculate preference score
               $preferenceScore = $distanceNegative / ($distancePositive + $distanceNegative);

               // Determine recommendation based on preference score
               $recommendation = $preferenceScore > 0.30 ? 'TKJ' : 'TKR';

               $assessment = $assessments->where('penilaian_id', $row['penilaian_id'])->first();

               $results->push([
                    'penilaian_id' => $row['penilaian_id'],
                    'peserta_didik_id' => $row['peserta_didik_id'],
                    'tahun_ajaran' => $assessment->tahun_ajaran,
                    'distance_positive' => $distancePositive,
                    'distance_negative' => $distanceNegative,
                    'preference_score' => $preferenceScore,
                    'recommendation' => $recommendation,
                    'assessment' => $assessment
               ]);
          }

          return $results;
     }

     /**
      * Save calculation results to database
      */
     private function saveResults(Collection $results, array $normalizedMatrix, array $weightedMatrix): void
     {
          foreach ($results as $index => $result) {
               $normalized = $normalizedMatrix[$index];
               $weighted = $weightedMatrix[$index];

               PerhitunganTopsis::updateOrCreate(
                    [
                         'peserta_didik_id' => $result['peserta_didik_id'],
                         'penilaian_id' => $result['penilaian_id'],
                         'tahun_ajaran' => $result['tahun_ajaran']
                    ],
                    [
                         // Normalized values
                         'normalized_n1' => $normalized['n1'],
                         'normalized_n2' => $normalized['n2'],
                         'normalized_n3' => $normalized['n3'],
                         'normalized_n4' => $normalized['n4'],
                         'normalized_n5' => $normalized['n5'],
                         'normalized_n6' => $normalized['n6'],
                         'normalized_ma' => $normalized['ma'],
                         'normalized_mb' => $normalized['mb'],
                         'normalized_mc' => $normalized['mc'],
                         'normalized_md' => $normalized['md'],
                         'normalized_bb' => $normalized['bb'],
                         'normalized_bp' => $normalized['bp'],

                         // Weighted values
                         'weighted_n1' => $weighted['n1'],
                         'weighted_n2' => $weighted['n2'],
                         'weighted_n3' => $weighted['n3'],
                         'weighted_n4' => $weighted['n4'],
                         'weighted_n5' => $weighted['n5'],
                         'weighted_n6' => $weighted['n6'],
                         'weighted_ma' => $weighted['ma'],
                         'weighted_mb' => $weighted['mb'],
                         'weighted_mc' => $weighted['mc'],
                         'weighted_md' => $weighted['md'],
                         'weighted_bb' => $weighted['bb'],
                         'weighted_bp' => $weighted['bp'],

                         // Results
                         'jarak_positif' => $result['distance_positive'],
                         'jarak_negatif' => $result['distance_negative'],
                         'nilai_preferensi' => $result['preference_score'],
                         'jurusan_rekomendasi' => $result['recommendation'],
                         'tanggal_perhitungan' => now()
                    ]
               );

               // Update assessment status
               $result['assessment']->update(['sudah_dihitung' => true]);
          }
     }

     /**
      * Get criteria weights
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

          return $weights;
     }

     /**
      * Get calculation statistics
      */
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
               'average_preference_score' => $calculations->avg('nilai_preferensi'),
               'highest_preference_score' => $calculations->max('nilai_preferensi'),
               'lowest_preference_score' => $calculations->min('nilai_preferensi'),
          ];
     }
}
