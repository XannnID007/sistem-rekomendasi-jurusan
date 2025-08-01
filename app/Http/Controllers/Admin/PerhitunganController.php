<?php
// app/Http/Controllers/Admin/PerhitunganController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PesertaDidik;
use App\Models\PenilaianPesertaDidik;
use App\Models\PerhitunganTopsis;
use App\Services\TopsisCalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class PerhitunganController extends Controller
{
    protected $topsisService;

    public function __construct(TopsisCalculationService $topsisService)
    {
        $this->topsisService = $topsisService;
    }

    /**
     * Display a listing of calculations
     */
    public function index(Request $request)
    {
        $query = PerhitunganTopsis::with(['pesertaDidik', 'penilaian'])
            ->orderBy('tanggal_perhitungan', 'desc');

        // Filter by academic year
        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->get('tahun_ajaran'));
        }

        // Filter by recommendation
        if ($request->filled('jurusan_rekomendasi')) {
            $query->where('jurusan_rekomendasi', $request->get('jurusan_rekomendasi'));
        }

        // Search by name or NISN
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->whereHas('pesertaDidik', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $perhitungan = $query->paginate(15);

        // Get filter options
        $tahunAjaran = PerhitunganTopsis::distinct()->pluck('tahun_ajaran');

        // Get statistics
        $statistics = [
            'total' => PerhitunganTopsis::count(),
            'tkj' => PerhitunganTopsis::where('jurusan_rekomendasi', 'TKJ')->count(),
            'tkr' => PerhitunganTopsis::where('jurusan_rekomendasi', 'TKR')->count(),
            'rata_preferensi' => PerhitunganTopsis::avg('nilai_preferensi')
        ];

        return view('admin.perhitungan.index', compact('perhitungan', 'tahunAjaran', 'statistics'));
    }

    /**
     * Show form for new calculation
     */
    public function create()
    {
        // Validate criteria weights first
        if (!$this->topsisService->validateWeights()) {
            return redirect()
                ->route('admin.kriteria.index')
                ->with('error', 'Total bobot kriteria harus sama dengan 100% (1.0). Silakan periksa dan perbaiki bobot kriteria terlebih dahulu.');
        }

        // Get peserta didik yang belum dihitung atau perlu dihitung ulang
        $pesertaDidik = PesertaDidik::with(['penilaianTerbaru', 'perhitunganTerbaru'])
            ->whereHas('penilaian', function ($query) {
                $query->readyForCalculation();
            })
            ->get()
            ->filter(function ($pd) {
                $penilaian = $pd->penilaianTerbaru;
                $perhitungan = $pd->perhitunganTerbaru;

                if (!$penilaian || !$penilaian->isReadyForCalculation()) {
                    return false;
                }

                // Tampilkan jika belum ada perhitungan atau penilaian sudah diupdate
                return !$penilaian->sudah_dihitung ||
                    !$perhitungan ||
                    $penilaian->updated_at > $perhitungan->tanggal_perhitungan;
            });

        $totalBelumDihitung = $pesertaDidik->count();
        $totalSudahDihitung = PerhitunganTopsis::count();

        // Get criteria info for debugging
        $criteriaInfo = $this->topsisService->getCriteriaInfo();

        return view('admin.perhitungan.create', compact(
            'pesertaDidik',
            'totalBelumDihitung',
            'totalSudahDihitung',
            'criteriaInfo'
        ));
    }

    /**
     * Calculate TOPSIS for specific peserta didik
     */
    public function calculate(Request $request)
    {
        $request->validate([
            'peserta_didik_ids' => 'required|array|min:1',
            'peserta_didik_ids.*' => 'exists:peserta_didik,peserta_didik_id'
        ]);

        try {
            // Validate criteria weights
            if (!$this->topsisService->validateWeights()) {
                return back()
                    ->withInput()
                    ->with('error', 'Total bobot kriteria tidak valid. Silakan periksa pengaturan kriteria.');
            }

            $pesertaDidikIds = $request->get('peserta_didik_ids');
            $results = collect();
            $errors = [];

            foreach ($pesertaDidikIds as $pesertaDidikId) {
                try {
                    $penilaian = PenilaianPesertaDidik::where('peserta_didik_id', $pesertaDidikId)
                        ->readyForCalculation()
                        ->latest()
                        ->first();

                    if (!$penilaian) {
                        $pesertaDidik = PesertaDidik::find($pesertaDidikId);
                        $errors[] = "Data penilaian untuk {$pesertaDidik->nama_lengkap} tidak lengkap atau tidak ditemukan.";
                        continue;
                    }

                    if (!$penilaian->isReadyForCalculation()) {
                        $pesertaDidik = PesertaDidik::find($pesertaDidikId);
                        $missingFields = $penilaian->getMissingFields();
                        $errors[] = "Data penilaian untuk {$pesertaDidik->nama_lengkap} tidak lengkap. Field yang hilang: " . implode(', ', $missingFields);
                        continue;
                    }

                    $result = $this->topsisService->calculateTopsis($penilaian->penilaian_id);
                    $results = $results->merge($result);
                } catch (Exception $e) {
                    $pesertaDidik = PesertaDidik::find($pesertaDidikId);
                    $errors[] = "Gagal menghitung TOPSIS untuk {$pesertaDidik->nama_lengkap}: " . $e->getMessage();
                    Log::error("TOPSIS calculation failed for peserta_didik_id: {$pesertaDidikId}", [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }

            $successCount = $results->count();
            $errorCount = count($errors);

            if ($successCount > 0 && $errorCount == 0) {
                return redirect()
                    ->route('admin.perhitungan.index')
                    ->with('success', "Berhasil menghitung TOPSIS untuk {$successCount} peserta didik");
            } elseif ($successCount > 0 && $errorCount > 0) {
                $errorMessage = "Berhasil menghitung {$successCount} peserta didik. Gagal: " . implode(' | ', $errors);
                return redirect()
                    ->route('admin.perhitungan.index')
                    ->with('error', $errorMessage);
            } else {
                return back()
                    ->withInput()
                    ->with('error', 'Semua perhitungan gagal: ' . implode(' | ', $errors));
            }
        } catch (Exception $e) {
            Log::error('TOPSIS calculation error: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Gagal melakukan perhitungan: ' . $e->getMessage());
        }
    }

    /**
     * Calculate TOPSIS for all eligible peserta didik
     */
    public function calculateAll()
    {
        try {
            // Validate criteria weights
            if (!$this->topsisService->validateWeights()) {
                return back()
                    ->with('error', 'Total bobot kriteria tidak valid. Silakan periksa pengaturan kriteria terlebih dahulu.');
            }

            // Get all uncalculated assessments that are ready
            $readyAssessments = PenilaianPesertaDidik::with('pesertaDidik')
                ->readyForCalculation()
                ->uncalculated()
                ->get();

            if ($readyAssessments->isEmpty()) {
                return back()
                    ->with('error', 'Tidak ada data penilaian yang siap untuk dihitung.');
            }

            // Group by academic year and calculate
            $results = collect();
            $errors = [];

            foreach ($readyAssessments->groupBy('tahun_ajaran') as $tahunAjaran => $assessments) {
                try {
                    // Calculate for this academic year
                    $yearResults = $this->topsisService->calculateTopsis();
                    $results = $results->merge($yearResults);
                } catch (Exception $e) {
                    $errors[] = "Gagal menghitung TOPSIS untuk tahun ajaran {$tahunAjaran}: " . $e->getMessage();
                    Log::error("TOPSIS calculation failed for academic year: {$tahunAjaran}", [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }

            $successCount = $results->count();

            if ($successCount > 0) {
                $message = "Berhasil menghitung TOPSIS untuk {$successCount} peserta didik";
                if (!empty($errors)) {
                    $message .= ". Beberapa error: " . implode(' | ', $errors);
                }
                return redirect()
                    ->route('admin.perhitungan.index')
                    ->with('success', $message);
            } else {
                return back()
                    ->with('error', 'Semua perhitungan gagal: ' . implode(' | ', $errors));
            }
        } catch (Exception $e) {
            Log::error('TOPSIS calculateAll error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->with('error', 'Gagal melakukan perhitungan: ' . $e->getMessage());
        }
    }

    /**
     * Display calculation details
     */
    public function show(PerhitunganTopsis $perhitungan)
    {
        $perhitungan->load(['pesertaDidik', 'penilaian']);

        return view('admin.perhitungan.show', compact('perhitungan'));
    }

    /**
     * Display detailed calculation steps
     */
    public function detail(PesertaDidik $pesertaDidik)
    {
        $pesertaDidik->load(['penilaianTerbaru', 'perhitunganTerbaru']);

        if (!$pesertaDidik->perhitunganTerbaru) {
            return redirect()
                ->route('admin.perhitungan.index')
                ->with('error', 'Belum ada perhitungan untuk peserta didik ini');
        }

        // Get all data for matrix display
        $allPenilaian = PenilaianPesertaDidik::with('pesertaDidik')
            ->where('tahun_ajaran', $pesertaDidik->perhitunganTerbaru->tahun_ajaran)
            ->readyForCalculation()
            ->get();

        $allPerhitungan = PerhitunganTopsis::with('pesertaDidik')
            ->where('tahun_ajaran', $pesertaDidik->perhitunganTerbaru->tahun_ajaran)
            ->get();

        return view('admin.perhitungan.detail', compact('pesertaDidik', 'allPenilaian', 'allPerhitungan'));
    }

    /**
     * Remove calculation
     */
    public function destroy(PerhitunganTopsis $perhitungan)
    {
        try {
            // Reset penilaian status
            if ($perhitungan->penilaian) {
                $perhitungan->penilaian->markAsUncalculated();
            }

            $perhitungan->delete();

            return redirect()
                ->route('admin.perhitungan.index')
                ->with('success', 'Perhitungan berhasil dihapus');
        } catch (Exception $e) {
            Log::error('Failed to delete calculation: ' . $e->getMessage());
            return back()
                ->with('error', 'Gagal menghapus perhitungan: ' . $e->getMessage());
        }
    }

    /**
     * Recalculate specific calculation
     */
    public function recalculate(PerhitunganTopsis $perhitungan)
    {
        try {
            if (!$this->topsisService->validateWeights()) {
                return back()
                    ->with('error', 'Total bobot kriteria tidak valid. Silakan periksa pengaturan kriteria.');
            }

            // Mark as uncalculated first
            if ($perhitungan->penilaian) {
                $perhitungan->penilaian->markAsUncalculated();
            }

            // Recalculate
            $result = $this->topsisService->calculateTopsis($perhitungan->penilaian_id);

            if ($result->isNotEmpty()) {
                return redirect()
                    ->route('admin.perhitungan.show', $perhitungan)
                    ->with('success', 'Perhitungan berhasil diperbarui');
            } else {
                return back()
                    ->with('error', 'Gagal memperbarui perhitungan');
            }
        } catch (Exception $e) {
            Log::error('Failed to recalculate: ' . $e->getMessage());
            return back()
                ->with('error', 'Gagal memperbarui perhitungan: ' . $e->getMessage());
        }
    }

    /**
     * Get calculation diagnostics
     */
    public function diagnostics()
    {
        try {
            $criteriaInfo = $this->topsisService->getCriteriaInfo();
            $statistics = $this->topsisService->getCalculationStatistics();

            // Get assessments status
            $totalAssessments = PenilaianPesertaDidik::count();
            $readyAssessments = PenilaianPesertaDidik::readyForCalculation()->count();
            $calculatedAssessments = PenilaianPesertaDidik::where('sudah_dihitung', true)->count();
            $pendingAssessments = PenilaianPesertaDidik::readyForCalculation()->uncalculated()->count();

            return response()->json([
                'criteria_info' => $criteriaInfo,
                'statistics' => $statistics,
                'assessments_status' => [
                    'total' => $totalAssessments,
                    'ready' => $readyAssessments,
                    'calculated' => $calculatedAssessments,
                    'pending' => $pendingAssessments,
                ],
                'system_status' => 'OK'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'system_status' => 'ERROR'
            ], 500);
        }
    }
}
