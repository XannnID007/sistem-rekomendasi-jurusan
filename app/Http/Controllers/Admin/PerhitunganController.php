<?php
// app/Http/Controllers/Admin/PerhitunganController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PesertaDidik;
use App\Models\PenilaianPesertaDidik;
use App\Models\PerhitunganTopsis;
use App\Services\TopsisCalculationService;
use Illuminate\Http\Request;

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
        // Get peserta didik yang belum dihitung atau perlu dihitung ulang
        $pesertaDidik = PesertaDidik::with(['penilaianTerbaru', 'perhitunganTerbaru'])
            ->whereHas('penilaian')
            ->get()
            ->filter(function ($pd) {
                $penilaian = $pd->penilaianTerbaru;
                $perhitungan = $pd->perhitunganTerbaru;

                // Tampilkan jika belum ada perhitungan atau penilaian sudah diupdate
                return !$penilaian->sudah_dihitung ||
                    !$perhitungan ||
                    $penilaian->updated_at > $perhitungan->tanggal_perhitungan;
            });

        $totalBelumDihitung = $pesertaDidik->count();
        $totalSudahDihitung = PerhitunganTopsis::count();

        return view('admin.perhitungan.create', compact('pesertaDidik', 'totalBelumDihitung', 'totalSudahDihitung'));
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
            $pesertaDidikIds = $request->get('peserta_didik_ids');
            $results = collect();

            foreach ($pesertaDidikIds as $pesertaDidikId) {
                $penilaian = PenilaianPesertaDidik::where('peserta_didik_id', $pesertaDidikId)
                    ->latest()
                    ->first();

                if ($penilaian) {
                    $result = $this->topsisService->calculateTopsis($penilaian->penilaian_id);
                    $results = $results->merge($result);
                }
            }

            return redirect()
                ->route('admin.perhitungan.index')
                ->with('success', "Berhasil menghitung TOPSIS untuk {$results->count()} peserta didik");
        } catch (\Exception $e) {
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
            $results = $this->topsisService->calculateTopsis();

            return redirect()
                ->route('admin.perhitungan.index')
                ->with('success', "Berhasil menghitung TOPSIS untuk semua peserta didik ({$results->count()} siswa)");
        } catch (\Exception $e) {
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
                $perhitungan->penilaian->update(['sudah_dihitung' => false]);
            }

            $perhitungan->delete();

            return redirect()
                ->route('admin.perhitungan.index')
                ->with('success', 'Perhitungan berhasil dihapus');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal menghapus perhitungan: ' . $e->getMessage());
        }
    }
}
