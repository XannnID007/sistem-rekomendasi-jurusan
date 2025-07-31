<?php
// app/Http/Controllers/Admin/RekomendasiController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PerhitunganTopsis;
use Illuminate\Http\Request;

class RekomendasiController extends Controller
{
    /**
     * Display recommendations
     */
    public function index(Request $request)
    {
        $query = PerhitunganTopsis::with(['pesertaDidik', 'penilaian'])
            ->orderBy('nilai_preferensi', 'desc');

        // Filter by academic year
        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->get('tahun_ajaran'));
        }

        // Filter by recommendation
        if ($request->filled('jurusan_rekomendasi')) {
            $query->where('jurusan_rekomendasi', $request->get('jurusan_rekomendasi'));
        }

        // Filter by preference score range
        if ($request->filled('min_preferensi')) {
            $query->where('nilai_preferensi', '>=', $request->get('min_preferensi'));
        }
        if ($request->filled('max_preferensi')) {
            $query->where('nilai_preferensi', '<=', $request->get('max_preferensi'));
        }

        // Search by name or NISN
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->whereHas('pesertaDidik', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $rekomendasi = $query->paginate(20);

        // Get filter options
        $tahunAjaran = PerhitunganTopsis::distinct()->pluck('tahun_ajaran');

        // Get statistics
        $statistics = [
            'total' => PerhitunganTopsis::count(),
            'tkj' => PerhitunganTopsis::where('jurusan_rekomendasi', 'TKJ')->count(),
            'tkr' => PerhitunganTopsis::where('jurusan_rekomendasi', 'TKR')->count(),
            'rata_preferensi' => PerhitunganTopsis::avg('nilai_preferensi'),
            'tertinggi' => PerhitunganTopsis::max('nilai_preferensi'),
            'terendah' => PerhitunganTopsis::min('nilai_preferensi')
        ];

        // Get top performers
        $topPerformers = PerhitunganTopsis::with('pesertaDidik')
            ->orderBy('nilai_preferensi', 'desc')
            ->limit(5)
            ->get();

        return view('admin.rekomendasi.index', compact(
            'rekomendasi',
            'tahunAjaran',
            'statistics',
            'topPerformers'
        ));
    }

    /**
     * Display detailed recommendation
     */
    public function detail(PerhitunganTopsis $perhitungan)
    {
        $perhitungan->load(['pesertaDidik', 'penilaian']);

        // Get comparison data (students with similar scores)
        $similarStudents = PerhitunganTopsis::with('pesertaDidik')
            ->where('perhitungan_id', '!=', $perhitungan->perhitungan_id)
            ->where('tahun_ajaran', $perhitungan->tahun_ajaran)
            ->whereBetween('nilai_preferensi', [
                $perhitungan->nilai_preferensi - 0.1,
                $perhitungan->nilai_preferensi + 0.1
            ])
            ->orderBy('nilai_preferensi', 'desc')
            ->limit(5)
            ->get();

        // Get ranking
        $ranking = PerhitunganTopsis::where('tahun_ajaran', $perhitungan->tahun_ajaran)
            ->where('nilai_preferensi', '>', $perhitungan->nilai_preferensi)
            ->count() + 1;

        $totalStudents = PerhitunganTopsis::where('tahun_ajaran', $perhitungan->tahun_ajaran)->count();

        return view('admin.rekomendasi.detail', compact(
            'perhitungan',
            'similarStudents',
            'ranking',
            'totalStudents'
        ));
    }

    /**
     * Filter recommendations
     */
    public function filter(Request $request)
    {
        // This method handles AJAX requests for dynamic filtering
        $query = PerhitunganTopsis::with(['pesertaDidik', 'penilaian']);

        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->get('tahun_ajaran'));
        }

        if ($request->filled('jurusan_rekomendasi')) {
            $query->where('jurusan_rekomendasi', $request->get('jurusan_rekomendasi'));
        }

        if ($request->filled('min_preferensi')) {
            $query->where('nilai_preferensi', '>=', $request->get('min_preferensi'));
        }

        if ($request->filled('max_preferensi')) {
            $query->where('nilai_preferensi', '<=', $request->get('max_preferensi'));
        }

        $rekomendasi = $query->orderBy('nilai_preferensi', 'desc')->get();

        return response()->json([
            'data' => $rekomendasi,
            'count' => $rekomendasi->count()
        ]);
    }

    /**
     * Export recommendations
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'excel');
        $tahunAjaran = $request->get('tahun_ajaran');

        $query = PerhitunganTopsis::with(['pesertaDidik', 'penilaian'])
            ->orderBy('nilai_preferensi', 'desc');

        if ($tahunAjaran) {
            $query->where('tahun_ajaran', $tahunAjaran);
        }

        $data = $query->get();

        try {
            switch ($format) {
                case 'pdf':
                    return $this->exportToPdf($data, $tahunAjaran);
                case 'csv':
                    return $this->exportToCsv($data, $tahunAjaran);
                default:
                    return $this->exportToExcel($data, $tahunAjaran);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengekspor data: ' . $e->getMessage());
        }
    }

    /**
     * Export to Excel
     */
    private function exportToExcel($data, $tahunAjaran = null)
    {
        $filename = 'rekomendasi_jurusan_' . ($tahunAjaran ?: 'semua') . '_' . date('Y-m-d') . '.xlsx';

        // Simple CSV export (you can use Laravel Excel for better formatting)
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            // Header
            fputcsv($file, [
                'No',
                'NISN',
                'Nama Lengkap',
                'Jenis Kelamin',
                'Nilai Preferensi',
                'Rekomendasi Jurusan',
                'Tanggal Perhitungan'
            ]);

            // Data
            foreach ($data as $index => $item) {
                fputcsv($file, [
                    $index + 1,
                    $item->pesertaDidik->nisn,
                    $item->pesertaDidik->nama_lengkap,
                    $item->pesertaDidik->jenis_kelamin_lengkap,
                    number_format($item->nilai_preferensi, 4),
                    $item->rekomendasi_lengkap,
                    $item->tanggal_perhitungan->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export to CSV
     */
    private function exportToCsv($data, $tahunAjaran = null)
    {
        $filename = 'rekomendasi_jurusan_' . ($tahunAjaran ?: 'semua') . '_' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            // Header
            fputcsv($file, [
                'No',
                'NISN',
                'Nama Lengkap',
                'Jenis Kelamin',
                'Nilai Preferensi',
                'Rekomendasi Jurusan',
                'Tanggal Perhitungan'
            ]);

            // Data
            foreach ($data as $index => $item) {
                fputcsv($file, [
                    $index + 1,
                    $item->pesertaDidik->nisn,
                    $item->pesertaDidik->nama_lengkap,
                    $item->pesertaDidik->jenis_kelamin_lengkap,
                    number_format($item->nilai_preferensi, 4),
                    $item->rekomendasi_lengkap,
                    $item->tanggal_perhitungan->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export to PDF (placeholder - you can use DomPDF or similar)
     */
    private function exportToPdf($data, $tahunAjaran = null)
    {
        // For now, return CSV. Implement PDF export with DomPDF later
        return $this->exportToCsv($data, $tahunAjaran);
    }
}
