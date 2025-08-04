<?php
// app/Http/Controllers/Admin/LaporanController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\PerhitunganTopsis;
use App\Models\PesertaDidik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * Display a listing of reports
     */
    public function index(Request $request)
    {
        $query = Laporan::with('pembuatLaporan')->orderBy('created_at', 'desc');

        // Filter by report type
        if ($request->filled('jenis_laporan')) {
            $query->where('jenis_laporan', $request->get('jenis_laporan'));
        }

        // Filter by academic year
        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->get('tahun_ajaran'));
        }

        // Search by title
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('judul_laporan', 'like', "%{$search}%");
        }

        $laporan = $query->paginate(15);

        // Get filter options
        $tahunAjaran = Laporan::distinct()->pluck('tahun_ajaran');
        $jenisLaporan = ['individual', 'ringkasan', 'perbandingan'];

        return view('admin.laporan.index', compact('laporan', 'tahunAjaran', 'jenisLaporan'));
    }

    /**
     * Show the form for creating a new report
     */
    public function create()
    {
        // Get available data for report generation
        $tahunAjaran = PerhitunganTopsis::distinct()->pluck('tahun_ajaran');
        $totalPesertaDidik = PesertaDidik::count();
        $totalPerhitungan = PerhitunganTopsis::count();

        return view('admin.laporan.create', compact('tahunAjaran', 'totalPesertaDidik', 'totalPerhitungan'));
    }

    /**
     * Store a newly created report
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_laporan' => 'required|string|max:255',
            'jenis_laporan' => 'required|in:individual,ringkasan,perbandingan',
            'tahun_ajaran' => 'required|string|max:9',
            'parameter' => 'nullable|array',
        ]);

        try {
            $laporan = Laporan::create([
                'judul_laporan' => $validated['judul_laporan'],
                'jenis_laporan' => $validated['jenis_laporan'],
                'tahun_ajaran' => $validated['tahun_ajaran'],
                'dibuat_oleh' => auth()->id(),
                'parameter' => $validated['parameter'] ?? [],
            ]);

            // Generate PDF file immediately
            $this->generateReportFile($laporan);

            return redirect()
                ->route('admin.laporan.show', $laporan)
                ->with('success', 'Laporan berhasil dibuat dan file PDF telah digenerate');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal membuat laporan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified report
     */
    public function show(Laporan $laporan)
    {
        $laporan->load('pembuatLaporan');

        // Get report data based on type
        $reportData = $this->getReportData($laporan);

        return view('admin.laporan.show', compact('laporan', 'reportData'));
    }

    /**
     * Download the specified report
     */
    public function download(Laporan $laporan)
    {
        // Generate file if not exists
        if (!$laporan->file_path || !Storage::exists($laporan->file_path)) {
            $this->generateReportFile($laporan);
        }

        if (!$laporan->file_path || !Storage::exists($laporan->file_path)) {
            return back()->with('error', 'File laporan tidak ditemukan');
        }

        $filename = $laporan->judul_laporan . '_' . now()->format('Y-m-d') . '.pdf';

        return Storage::download($laporan->file_path, $filename);
    }

    /**
     * Remove the specified report
     */
    public function destroy(Laporan $laporan)
    {
        try {
            // Delete file if exists
            if ($laporan->file_path && Storage::exists($laporan->file_path)) {
                Storage::delete($laporan->file_path);
            }

            $laporan->delete();

            return redirect()
                ->route('admin.laporan.index')
                ->with('success', 'Laporan berhasil dihapus');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal menghapus laporan: ' . $e->getMessage());
        }
    }

    /**
     * Generate individual report
     */
    public function generateIndividual(Request $request)
    {
        $validated = $request->validate([
            'tahun_ajaran' => 'required|string',
            'peserta_didik_ids' => 'required|array|min:1',
            'peserta_didik_ids.*' => 'exists:peserta_didik,peserta_didik_id'
        ]);

        try {
            $judul = 'Laporan Individual - ' . $validated['tahun_ajaran'];

            $laporan = Laporan::create([
                'judul_laporan' => $judul,
                'jenis_laporan' => 'individual',
                'tahun_ajaran' => $validated['tahun_ajaran'],
                'dibuat_oleh' => auth()->id(),
                'parameter' => [
                    'peserta_didik_ids' => $validated['peserta_didik_ids']
                ],
            ]);

            // Generate PDF file
            $this->generateReportFile($laporan);

            return redirect()
                ->route('admin.laporan.show', $laporan)
                ->with('success', 'Laporan individual berhasil dibuat dan file PDF telah digenerate');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal membuat laporan: ' . $e->getMessage());
        }
    }

    /**
     * Generate summary report
     */
    public function generateSummary(Request $request)
    {
        $validated = $request->validate([
            'tahun_ajaran' => 'required|string',
            'include_charts' => 'boolean',
            'include_statistics' => 'boolean'
        ]);

        try {
            $judul = 'Laporan Ringkasan - ' . $validated['tahun_ajaran'];

            $laporan = Laporan::create([
                'judul_laporan' => $judul,
                'jenis_laporan' => 'ringkasan',
                'tahun_ajaran' => $validated['tahun_ajaran'],
                'dibuat_oleh' => auth()->id(),
                'parameter' => [
                    'include_charts' => $validated['include_charts'] ?? false,
                    'include_statistics' => $validated['include_statistics'] ?? true
                ],
            ]);

            // Generate PDF file
            $this->generateReportFile($laporan);

            return redirect()
                ->route('admin.laporan.show', $laporan)
                ->with('success', 'Laporan ringkasan berhasil dibuat dan file PDF telah digenerate');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal membuat laporan: ' . $e->getMessage());
        }
    }

    /**
     * Generate comparison report
     */
    public function generateComparison(Request $request)
    {
        $validated = $request->validate([
            'tahun_ajaran' => 'required|array|min:2',
            'tahun_ajaran.*' => 'string',
            'comparison_criteria' => 'required|array|min:1'
        ]);

        try {
            $judul = 'Laporan Perbandingan - ' . implode(' vs ', $validated['tahun_ajaran']);

            $laporan = Laporan::create([
                'judul_laporan' => $judul,
                'jenis_laporan' => 'perbandingan',
                'tahun_ajaran' => implode(',', $validated['tahun_ajaran']),
                'dibuat_oleh' => auth()->id(),
                'parameter' => [
                    'tahun_ajaran' => $validated['tahun_ajaran'],
                    'comparison_criteria' => $validated['comparison_criteria']
                ],
            ]);

            // Generate PDF file
            $this->generateReportFile($laporan);

            return redirect()
                ->route('admin.laporan.show', $laporan)
                ->with('success', 'Laporan perbandingan berhasil dibuat dan file PDF telah digenerate');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal membuat laporan: ' . $e->getMessage());
        }
    }

    /**
     * Get students data for AJAX
     */
    public function getStudents(Request $request)
    {
        $tahunAjaran = $request->get('tahun_ajaran');

        if (!$tahunAjaran) {
            return response()->json(['students' => []]);
        }

        $students = PesertaDidik::where('tahun_ajaran', $tahunAjaran)
            ->whereHas('perhitunganTopsis')
            ->with(['perhitunganTerbaru'])
            ->orderBy('nama_lengkap')
            ->get()
            ->map(function ($student) {
                return [
                    'id' => $student->peserta_didik_id,
                    'nama' => $student->nama_lengkap,
                    'nisn' => $student->nisn,
                    'rekomendasi' => $student->perhitunganTerbaru->jurusan_rekomendasi ?? '-',
                    'nilai_preferensi' => $student->perhitunganTerbaru ?
                        number_format($student->perhitunganTerbaru->nilai_preferensi, 4) : '-'
                ];
            });

        return response()->json(['students' => $students]);
    }

    /**
     * Get report data based on type
     */
    private function getReportData(Laporan $laporan)
    {
        switch ($laporan->jenis_laporan) {
            case 'individual':
                return $this->getIndividualReportData($laporan);
            case 'ringkasan':
                return $this->getSummaryReportData($laporan);
            case 'perbandingan':
                return $this->getComparisonReportData($laporan);
            default:
                return [];
        }
    }

    /**
     * Get individual report data
     */
    private function getIndividualReportData(Laporan $laporan)
    {
        $pesertaDidikIds = $laporan->parameter['peserta_didik_ids'] ?? [];

        if (empty($pesertaDidikIds)) {
            return [
                'perhitungan' => collect(),
                'total_siswa' => 0,
                'rata_preferensi' => 0,
                'tkj_count' => 0,
                'tkr_count' => 0,
            ];
        }

        $data = PerhitunganTopsis::with(['pesertaDidik', 'penilaian'])
            ->whereIn('peserta_didik_id', $pesertaDidikIds)
            ->where('tahun_ajaran', $laporan->tahun_ajaran)
            ->orderBy('nilai_preferensi', 'desc')
            ->get();

        return [
            'perhitungan' => $data,
            'total_siswa' => $data->count(),
            'rata_preferensi' => $data->avg('nilai_preferensi') ?? 0,
            'tkj_count' => $data->where('jurusan_rekomendasi', 'TKJ')->count(),
            'tkr_count' => $data->where('jurusan_rekomendasi', 'TKR')->count(),
        ];
    }

    /**
     * Get summary report data
     */
    private function getSummaryReportData(Laporan $laporan)
    {
        $data = PerhitunganTopsis::with(['pesertaDidik', 'penilaian'])
            ->where('tahun_ajaran', $laporan->tahun_ajaran)
            ->get();

        if ($data->isEmpty()) {
            return [
                'total_siswa' => 0,
                'tkj_count' => 0,
                'tkr_count' => 0,
                'rata_preferensi' => 0,
                'tertinggi' => 0,
                'terendah' => 0,
                'distribusi_gender' => ['laki' => 0, 'perempuan' => 0],
                'top_performers' => collect(),
                'data_lengkap' => collect()
            ];
        }

        return [
            'total_siswa' => $data->count(),
            'tkj_count' => $data->where('jurusan_rekomendasi', 'TKJ')->count(),
            'tkr_count' => $data->where('jurusan_rekomendasi', 'TKR')->count(),
            'rata_preferensi' => $data->avg('nilai_preferensi'),
            'tertinggi' => $data->max('nilai_preferensi'),
            'terendah' => $data->min('nilai_preferensi'),
            'distribusi_gender' => [
                'laki' => $data->filter(fn($item) => $item->pesertaDidik->jenis_kelamin === 'L')->count(),
                'perempuan' => $data->filter(fn($item) => $item->pesertaDidik->jenis_kelamin === 'P')->count(),
            ],
            'top_performers' => $data->sortByDesc('nilai_preferensi')->take(10),
            'data_lengkap' => $data->sortByDesc('nilai_preferensi')
        ];
    }

    /**
     * Get comparison report data
     */
    private function getComparisonReportData(Laporan $laporan)
    {
        $tahunAjaran = $laporan->parameter['tahun_ajaran'] ?? [];
        $comparison = [];

        foreach ($tahunAjaran as $tahun) {
            $data = PerhitunganTopsis::with(['pesertaDidik', 'penilaian'])
                ->where('tahun_ajaran', $tahun)
                ->get();

            $comparison[$tahun] = [
                'total_siswa' => $data->count(),
                'tkj_count' => $data->where('jurusan_rekomendasi', 'TKJ')->count(),
                'tkr_count' => $data->where('jurusan_rekomendasi', 'TKR')->count(),
                'rata_preferensi' => $data->avg('nilai_preferensi') ?? 0,
                'tertinggi' => $data->max('nilai_preferensi') ?? 0,
                'terendah' => $data->min('nilai_preferensi') ?? 0,
            ];
        }

        return [
            'comparison' => $comparison,
            'tahun_ajaran' => $tahunAjaran
        ];
    }

    /**
     * Generate report PDF file
     */
    private function generateReportFile(Laporan $laporan)
    {
        try {
            $reportData = $this->getReportData($laporan);

            // Generate PDF using DomPDF
            $pdf = Pdf::loadView('admin.laporan.pdf.template', [
                'laporan' => $laporan,
                'reportData' => $reportData
            ]);

            // Set paper and orientation
            $pdf->setPaper('A4', 'portrait');

            // Generate filename
            $filename = 'laporan_' . $laporan->laporan_id . '_' . time() . '.pdf';
            $filepath = 'reports/' . $filename;

            // Save PDF to storage
            Storage::put($filepath, $pdf->output());

            // Update laporan with file path
            $laporan->update(['file_path' => $filepath]);

            return $filepath;
        } catch (\Exception $e) {
            throw new \Exception('Gagal generate PDF: ' . $e->getMessage());
        }
    }
}
