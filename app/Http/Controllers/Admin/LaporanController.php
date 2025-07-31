<?php
// app/Http/Controllers/Admin/LaporanController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\PerhitunganTopsis;
use App\Models\PesertaDidik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

            return redirect()
                ->route('admin.laporan.show', $laporan)
                ->with('success', 'Laporan berhasil dibuat');
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
        if (!$laporan->fileExists()) {
            // Generate file if not exists
            $this->generateReportFile($laporan);
        }

        return Storage::download($laporan->file_path, $laporan->judul_laporan . '.pdf');
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

            // Generate file
            $this->generateReportFile($laporan);

            return redirect()
                ->route('admin.laporan.show', $laporan)
                ->with('success', 'Laporan individual berhasil dibuat');
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

            // Generate file
            $this->generateReportFile($laporan);

            return redirect()
                ->route('admin.laporan.show', $laporan)
                ->with('success', 'Laporan ringkasan berhasil dibuat');
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

            // Generate file
            $this->generateReportFile($laporan);

            return redirect()
                ->route('admin.laporan.show', $laporan)
                ->with('success', 'Laporan perbandingan berhasil dibuat');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal membuat laporan: ' . $e->getMessage());
        }
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

        $data = PerhitunganTopsis::with(['pesertaDidik', 'penilaian'])
            ->whereIn('peserta_didik_id', $pesertaDidikIds)
            ->where('tahun_ajaran', $laporan->tahun_ajaran)
            ->orderBy('nilai_preferensi', 'desc')
            ->get();

        return [
            'perhitungan' => $data,
            'total_siswa' => $data->count(),
            'rata_preferensi' => $data->avg('nilai_preferensi'),
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
                'rata_preferensi' => $data->avg('nilai_preferensi'),
                'tertinggi' => $data->max('nilai_preferensi'),
                'terendah' => $data->min('nilai_preferensi'),
            ];
        }

        return [
            'comparison' => $comparison,
            'tahun_ajaran' => $tahunAjaran
        ];
    }

    /**
     * Generate report file (placeholder for actual implementation)
     */
    private function generateReportFile(Laporan $laporan)
    {
        // This is a placeholder. In real implementation, you would use:
        // - DomPDF or similar for PDF generation
        // - Laravel Excel for Excel files
        // - Custom HTML to PDF conversion

        $filename = 'laporan_' . $laporan->laporan_id . '_' . time() . '.pdf';
        $filepath = 'reports/' . $filename;

        // For now, create a simple text file as placeholder
        $content = $this->generateReportContent($laporan);
        Storage::put($filepath, $content);

        $laporan->update(['file_path' => $filepath]);

        return $filepath;
    }

    /**
     * Generate report content
     */
    private function generateReportContent(Laporan $laporan)
    {
        $reportData = $this->getReportData($laporan);

        $content = "LAPORAN SISTEM PENDUKUNG KEPUTUSAN\n";
        $content .= "SMK Penida 2 Katapang\n";
        $content .= str_repeat("=", 50) . "\n\n";

        $content .= "Judul: " . $laporan->judul_laporan . "\n";
        $content .= "Jenis: " . $laporan->jenis_laporan_indonesia . "\n";
        $content .= "Tahun Ajaran: " . $laporan->tahun_ajaran . "\n";
        $content .= "Dibuat oleh: " . $laporan->pembuatLaporan->full_name . "\n";
        $content .= "Tanggal: " . $laporan->created_at->format('d/m/Y H:i') . "\n\n";

        switch ($laporan->jenis_laporan) {
            case 'individual':
                $content .= $this->generateIndividualContent($reportData);
                break;
            case 'ringkasan':
                $content .= $this->generateSummaryContent($reportData);
                break;
            case 'perbandingan':
                $content .= $this->generateComparisonContent($reportData);
                break;
        }

        return $content;
    }

    /**
     * Generate individual report content
     */
    private function generateIndividualContent($data)
    {
        $content = "LAPORAN INDIVIDUAL\n";
        $content .= str_repeat("-", 30) . "\n\n";

        $content .= "Ringkasan:\n";
        $content .= "- Total Siswa: " . $data['total_siswa'] . "\n";
        $content .= "- Rata-rata Preferensi: " . number_format($data['rata_preferensi'], 4) . "\n";
        $content .= "- Rekomendasi TKJ: " . $data['tkj_count'] . " siswa\n";
        $content .= "- Rekomendasi TKR: " . $data['tkr_count'] . " siswa\n\n";

        $content .= "Detail Siswa:\n";
        foreach ($data['perhitungan'] as $index => $perhitungan) {
            $content .= ($index + 1) . ". " . $perhitungan->pesertaDidik->nama_lengkap . "\n";
            $content .= "   NISN: " . $perhitungan->pesertaDidik->nisn . "\n";
            $content .= "   Preferensi: " . number_format($perhitungan->nilai_preferensi, 4) . "\n";
            $content .= "   Rekomendasi: " . $perhitungan->rekomendasi_lengkap . "\n\n";
        }

        return $content;
    }

    /**
     * Generate summary report content
     */
    private function generateSummaryContent($data)
    {
        $content = "LAPORAN RINGKASAN\n";
        $content .= str_repeat("-", 30) . "\n\n";

        $content .= "Statistik Umum:\n";
        $content .= "- Total Siswa: " . $data['total_siswa'] . "\n";
        $content .= "- Rekomendasi TKJ: " . $data['tkj_count'] . " siswa (" .
            number_format($data['tkj_count'] / $data['total_siswa'] * 100, 1) . "%)\n";
        $content .= "- Rekomendasi TKR: " . $data['tkr_count'] . " siswa (" .
            number_format($data['tkr_count'] / $data['total_siswa'] * 100, 1) . "%)\n\n";

        $content .= "Statistik Preferensi:\n";
        $content .= "- Rata-rata: " . number_format($data['rata_preferensi'], 4) . "\n";
        $content .= "- Tertinggi: " . number_format($data['tertinggi'], 4) . "\n";
        $content .= "- Terendah: " . number_format($data['terendah'], 4) . "\n\n";

        $content .= "Distribusi Gender:\n";
        $content .= "- Laki-laki: " . $data['distribusi_gender']['laki'] . " siswa\n";
        $content .= "- Perempuan: " . $data['distribusi_gender']['perempuan'] . " siswa\n\n";

        $content .= "Top 10 Performer:\n";
        foreach ($data['top_performers'] as $index => $perhitungan) {
            $content .= ($index + 1) . ". " . $perhitungan->pesertaDidik->nama_lengkap .
                " (" . number_format($perhitungan->nilai_preferensi, 4) . ")\n";
        }

        return $content;
    }

    /**
     * Generate comparison report content
     */
    private function generateComparisonContent($data)
    {
        $content = "LAPORAN PERBANDINGAN\n";
        $content .= str_repeat("-", 30) . "\n\n";

        $content .= "Perbandingan Antar Tahun:\n";
        foreach ($data['comparison'] as $tahun => $stats) {
            $content .= "\nTahun Ajaran: " . $tahun . "\n";
            $content .= "- Total Siswa: " . $stats['total_siswa'] . "\n";
            $content .= "- TKJ: " . $stats['tkj_count'] . " (" .
                number_format($stats['tkj_count'] / $stats['total_siswa'] * 100, 1) . "%)\n";
            $content .= "- TKR: " . $stats['tkr_count'] . " (" .
                number_format($stats['tkr_count'] / $stats['total_siswa'] * 100, 1) . "%)\n";
            $content .= "- Rata-rata Preferensi: " . number_format($stats['rata_preferensi'], 4) . "\n";
        }

        return $content;
    }
}
