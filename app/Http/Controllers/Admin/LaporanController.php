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
use Illuminate\Support\Facades\Log;

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
        $tahunAjaran = Laporan::distinct()->pluck('tahun_ajaran')->filter();
        $jenisLaporan = ['individual', 'ringkasan', 'perbandingan'];

        return view('admin.laporan.index', compact('laporan', 'tahunAjaran', 'jenisLaporan'));
    }

    /**
     * Show the form for creating a new report
     */
    public function create()
    {
        // Get available data for report generation
        $tahunAjaran = PerhitunganTopsis::distinct()->pluck('tahun_ajaran')->filter();
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
            // Ensure parameter is properly handled as JSON
            $parameter = $validated['parameter'] ?? [];

            $laporan = Laporan::create([
                'judul_laporan' => $validated['judul_laporan'],
                'jenis_laporan' => $validated['jenis_laporan'],
                'tahun_ajaran' => $validated['tahun_ajaran'],
                'dibuat_oleh' => auth()->id(),
                'parameter' => json_encode($parameter), // Explicitly convert to JSON
            ]);

            // Generate PDF file immediately
            $this->generateReportFile($laporan);

            return redirect()
                ->route('admin.laporan.show', $laporan)
                ->with('success', 'Laporan berhasil dibuat dan file PDF telah digenerate');
        } catch (\Exception $e) {
            Log::error('Error creating laporan: ' . $e->getMessage());
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
        try {
            // Generate file if not exists
            if (!$laporan->file_path || !Storage::exists($laporan->file_path)) {
                $this->generateReportFile($laporan);
                $laporan->refresh();
            }

            if (!$laporan->file_path || !Storage::exists($laporan->file_path)) {
                return back()->with('error', 'File laporan tidak dapat digenerate');
            }

            $filename = str_replace(['/', ' '], ['_', '_'], $laporan->judul_laporan) . '_' . now()->format('Y-m-d') . '.pdf';

            return Storage::download($laporan->file_path, $filename);
        } catch (\Exception $e) {
            Log::error('Error downloading laporan: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengunduh laporan: ' . $e->getMessage());
        }
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
            Log::error('Error deleting laporan: ' . $e->getMessage());
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
        ], [
            'tahun_ajaran.required' => 'Tahun ajaran wajib dipilih',
            'peserta_didik_ids.required' => 'Pilih minimal satu peserta didik',
            'peserta_didik_ids.min' => 'Pilih minimal satu peserta didik',
        ]);

        try {
            $judul = 'Laporan Individual - ' . $validated['tahun_ajaran'];

            $laporan = Laporan::create([
                'judul_laporan' => $judul,
                'jenis_laporan' => 'individual',
                'tahun_ajaran' => $validated['tahun_ajaran'],
                'dibuat_oleh' => auth()->id(),
                'parameter' => json_encode([
                    'peserta_didik_ids' => $validated['peserta_didik_ids']
                ]),
            ]);

            // Generate PDF file
            $this->generateReportFile($laporan);

            return redirect()
                ->route('admin.laporan.show', $laporan)
                ->with('success', 'Laporan individual berhasil dibuat');
        } catch (\Exception $e) {
            Log::error('Error generating individual report: ' . $e->getMessage());
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
        ], [
            'tahun_ajaran.required' => 'Tahun ajaran wajib dipilih',
        ]);

        try {
            $judul = 'Laporan Ringkasan - ' . $validated['tahun_ajaran'];

            $laporan = Laporan::create([
                'judul_laporan' => $judul,
                'jenis_laporan' => 'ringkasan',
                'tahun_ajaran' => $validated['tahun_ajaran'],
                'dibuat_oleh' => auth()->id(),
                'parameter' => json_encode([
                    'include_charts' => $validated['include_charts'] ?? false,
                    'include_statistics' => $validated['include_statistics'] ?? true
                ]),
            ]);

            // Generate PDF file
            $this->generateReportFile($laporan);

            return redirect()
                ->route('admin.laporan.show', $laporan)
                ->with('success', 'Laporan ringkasan berhasil dibuat');
        } catch (\Exception $e) {
            Log::error('Error generating summary report: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Gagal membuat laporan: ' . $e->getMessage());
        }
    }

    public function generateComparison(Request $request)
    {
        // Debug request data
        Log::info('Comparison request data:', $request->all());

        $validated = $request->validate([
            'tahun_ajaran' => 'required|array|min:2',
            'tahun_ajaran.*' => 'string',
            'comparison_criteria' => 'required|array|min:1',
            'comparison_criteria.*' => 'string'
        ], [
            'tahun_ajaran.required' => 'Pilih minimal 2 tahun ajaran',
            'tahun_ajaran.array' => 'Format tahun ajaran tidak valid',
            'tahun_ajaran.min' => 'Pilih minimal 2 tahun ajaran untuk dibandingkan',
            'comparison_criteria.required' => 'Pilih minimal satu kriteria perbandingan',
            'comparison_criteria.array' => 'Format kriteria tidak valid',
            'comparison_criteria.min' => 'Pilih minimal satu kriteria perbandingan',
        ]);

        try {
            // Sanitize tahun ajaran
            $tahunAjaranList = array_map('trim', $validated['tahun_ajaran']);
            $tahunAjaranList = array_filter($tahunAjaranList); // Remove empty values

            if (count($tahunAjaranList) < 2) {
                return back()
                    ->withInput()
                    ->with('error', 'Pilih minimal 2 tahun ajaran yang valid untuk dibandingkan');
            }

            // Check if data exists for selected years
            $dataExists = [];
            foreach ($tahunAjaranList as $tahun) {
                $count = PerhitunganTopsis::where('tahun_ajaran', $tahun)->count();
                $dataExists[$tahun] = $count;
            }

            // Filter out years with no data and warn user
            $yearsWithData = array_filter($dataExists, function ($count) {
                return $count > 0;
            });

            if (empty($yearsWithData)) {
                return back()
                    ->withInput()
                    ->with('error', 'Tidak ada data perhitungan TOPSIS untuk tahun ajaran yang dipilih: ' . implode(', ', array_keys($dataExists)));
            }

            if (count($yearsWithData) < 2) {
                $availableYears = array_keys($yearsWithData);
                return back()
                    ->withInput()
                    ->with('error', 'Hanya ditemukan data untuk tahun: ' . implode(', ', $availableYears) . '. Diperlukan minimal 2 tahun dengan data untuk perbandingan.');
            }

            // Use only years that have data
            $finalYearsList = array_keys($yearsWithData);

            $judul = 'Laporan Perbandingan - ' . implode(' vs ', $finalYearsList);

            $laporan = Laporan::create([
                'judul_laporan' => $judul,
                'jenis_laporan' => 'perbandingan',
                'tahun_ajaran' => implode(',', $finalYearsList),
                'dibuat_oleh' => auth()->id(),
                'parameter' => json_encode([
                    'tahun_ajaran' => $finalYearsList,
                    'comparison_criteria' => $validated['comparison_criteria'],
                    'original_selection' => $tahunAjaranList,
                    'data_availability' => $dataExists
                ]),
            ]);

            // Generate PDF file
            $this->generateReportFile($laporan);

            $message = 'Laporan perbandingan berhasil dibuat';
            if (count($finalYearsList) < count($tahunAjaranList)) {
                $excludedYears = array_diff($tahunAjaranList, $finalYearsList);
                $message .= '. Catatan: Tahun ' . implode(', ', $excludedYears) . ' tidak disertakan karena tidak memiliki data.';
            }

            return redirect()
                ->route('admin.laporan.show', $laporan)
                ->with('success', $message);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error in generateComparison: ' . json_encode($e->errors()));
            return back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Error generating comparison report: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
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
        try {
            // Log request untuk debugging
            Log::info('getStudents method called', [
                'request_data' => $request->all(),
                'user_id' => auth()->id(),
                'user_role' => auth()->user()->role ?? 'unknown'
            ]);

            $tahunAjaran = $request->get('tahun_ajaran');

            if (!$tahunAjaran) {
                Log::warning('No tahun_ajaran provided in request');
                return response()->json([
                    'students' => [],
                    'count' => 0,
                    'message' => 'Tahun ajaran tidak ditemukan'
                ]);
            }

            Log::info('Processing request for tahun_ajaran: ' . $tahunAjaran);

            // Langkah 1: Cek apakah ada peserta didik untuk tahun ajaran ini
            $totalPesertaDidik = \App\Models\PesertaDidik::where('tahun_ajaran', $tahunAjaran)->count();
            Log::info('Total peserta didik found: ' . $totalPesertaDidik);

            if ($totalPesertaDidik === 0) {
                return response()->json([
                    'students' => [],
                    'count' => 0,
                    'message' => 'Tidak ada peserta didik untuk tahun ajaran ' . $tahunAjaran
                ]);
            }

            // Langkah 2: Cek apakah ada perhitungan TOPSIS
            $totalPerhitungan = \App\Models\PerhitunganTopsis::whereHas('pesertaDidik', function ($query) use ($tahunAjaran) {
                $query->where('tahun_ajaran', $tahunAjaran);
            })->count();
            Log::info('Total perhitungan TOPSIS found: ' . $totalPerhitungan);

            if ($totalPerhitungan === 0) {
                return response()->json([
                    'students' => [],
                    'count' => 0,
                    'message' => 'Belum ada perhitungan TOPSIS untuk tahun ajaran ' . $tahunAjaran
                ]);
            }

            // Langkah 3: Ambil data dengan query yang aman
            $students = \App\Models\PesertaDidik::where('tahun_ajaran', $tahunAjaran)
                ->whereHas('perhitunganTopsis', function ($query) {
                    $query->whereNotNull('nilai_preferensi');
                })
                ->with(['perhitunganTerbaru' => function ($query) {
                    $query->orderBy('tanggal_perhitungan', 'desc');
                }])
                ->orderBy('nama_lengkap')
                ->get();

            Log::info('Students with calculations found: ' . $students->count());

            // Langkah 4: Transform data dengan error handling
            $studentsData = $students->map(function ($student) {
                try {
                    $perhitungan = $student->perhitunganTerbaru;

                    // Handle tanggal dengan aman
                    $tanggalPerhitungan = '-';
                    if ($perhitungan) {
                        if ($perhitungan->tanggal_perhitungan) {
                            try {
                                $tanggalPerhitungan = \Carbon\Carbon::parse($perhitungan->tanggal_perhitungan)->format('d/m/Y');
                            } catch (\Exception $e) {
                                $tanggalPerhitungan = $perhitungan->created_at ? $perhitungan->created_at->format('d/m/Y') : '-';
                            }
                        } else {
                            $tanggalPerhitungan = $perhitungan->created_at ? $perhitungan->created_at->format('d/m/Y') : '-';
                        }
                    }

                    return [
                        'id' => $student->peserta_didik_id,
                        'nama' => $student->nama_lengkap ?? 'Nama tidak tersedia',
                        'nisn' => $student->nisn ?? 'NISN tidak tersedia',
                        'jenis_kelamin' => ($student->jenis_kelamin === 'L') ? 'Laki-laki' : 'Perempuan',
                        'rekomendasi' => $perhitungan ? ($perhitungan->jurusan_rekomendasi ?? '-') : '-',
                        'nilai_preferensi' => $perhitungan ? number_format($perhitungan->nilai_preferensi ?? 0, 4) : '-',
                        'tanggal_perhitungan' => $tanggalPerhitungan
                    ];
                } catch (\Exception $e) {
                    Log::error('Error processing student data', [
                        'student_id' => $student->peserta_didik_id ?? 'unknown',
                        'error' => $e->getMessage()
                    ]);

                    // Return safe default data
                    return [
                        'id' => $student->peserta_didik_id ?? 0,
                        'nama' => $student->nama_lengkap ?? 'Error loading name',
                        'nisn' => $student->nisn ?? 'Error loading NISN',
                        'jenis_kelamin' => 'Tidak diketahui',
                        'rekomendasi' => '-',
                        'nilai_preferensi' => '-',
                        'tanggal_perhitungan' => '-'
                    ];
                }
            });

            Log::info('Data transformation completed', [
                'students_processed' => $studentsData->count()
            ]);

            return response()->json([
                'students' => $studentsData,
                'count' => $studentsData->count(),
                'message' => 'Data berhasil dimuat',
                'debug_info' => [
                    'total_peserta_didik' => $totalPesertaDidik,
                    'total_perhitungan' => $totalPerhitungan,
                    'students_with_calculation' => $students->count()
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Critical error in getStudents method', [
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'stack_trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'students' => [],
                'count' => 0,
                'error' => 'Terjadi kesalahan sistem: ' . $e->getMessage(),
                'debug' => config('app.debug') ? [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ] : null
            ], 500);
        }
    }
    // Method safeDecodeParameter yang dibutuhkan untuk comparison report
    private function safeDecodeParameter($parameter)
    {
        if (is_string($parameter)) {
            try {
                return json_decode($parameter, true) ?? [];
            } catch (\Exception $e) {
                Log::error('Failed to decode parameter: ' . $e->getMessage());
                return [];
            }
        }

        if (is_array($parameter)) {
            return $parameter;
        }

        return [];
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
        // Decode parameter from JSON
        $parameter = is_string($laporan->parameter) ?
            json_decode($laporan->parameter, true) :
            $laporan->parameter;

        $pesertaDidikIds = $parameter['peserta_didik_ids'] ?? [];

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
     * Get comparison report data - ENHANCED VERSION
     */
    private function getComparisonReportData(Laporan $laporan)
    {
        try {
            Log::info('Getting comparison report data for laporan: ' . $laporan->laporan_id);

            // Safely decode parameter
            $parameter = $this->safeDecodeParameter($laporan->parameter);
            $tahunAjaran = $parameter['tahun_ajaran'] ?? [];

            // If no tahun_ajaran in parameter, try to split from laporan tahun_ajaran
            if (empty($tahunAjaran) && !empty($laporan->tahun_ajaran)) {
                $tahunAjaran = array_map('trim', explode(',', $laporan->tahun_ajaran));
                $tahunAjaran = array_filter($tahunAjaran); // Remove empty values
            }

            if (empty($tahunAjaran)) {
                Log::warning('No tahun_ajaran found for comparison report');
                return [
                    'comparison' => [],
                    'tahun_ajaran' => [],
                    'summary' => [
                        'total_years' => 0,
                        'total_students' => 0,
                        'total_tkj' => 0,
                        'total_tkr' => 0,
                        'avg_preference' => 0
                    ]
                ];
            }

            Log::info('Processing comparison for years: ' . implode(', ', $tahunAjaran));

            $comparison = [];
            $totalStudents = 0;
            $totalTKJ = 0;
            $totalTKR = 0;
            $allPreferences = [];

            foreach ($tahunAjaran as $tahun) {
                $tahun = trim($tahun);
                if (empty($tahun)) continue;

                Log::info('Processing year: ' . $tahun);

                $data = PerhitunganTopsis::with(['pesertaDidik', 'penilaian'])
                    ->where('tahun_ajaran', $tahun)
                    ->get();

                $yearStats = [
                    'total_siswa' => $data->count(),
                    'tkj_count' => $data->where('jurusan_rekomendasi', 'TKJ')->count(),
                    'tkr_count' => $data->where('jurusan_rekomendasi', 'TKR')->count(),
                    'rata_preferensi' => $data->avg('nilai_preferensi') ?? 0,
                    'tertinggi' => $data->max('nilai_preferensi') ?? 0,
                    'terendah' => $data->min('nilai_preferensi') ?? 0,
                    'gender_distribution' => [
                        'laki' => $data->filter(fn($item) => $item->pesertaDidik && $item->pesertaDidik->jenis_kelamin === 'L')->count(),
                        'perempuan' => $data->filter(fn($item) => $item->pesertaDidik && $item->pesertaDidik->jenis_kelamin === 'P')->count(),
                    ]
                ];

                $comparison[$tahun] = $yearStats;

                // Aggregate totals
                $totalStudents += $yearStats['total_siswa'];
                $totalTKJ += $yearStats['tkj_count'];
                $totalTKR += $yearStats['tkr_count'];

                // Collect all preference values for overall average
                $preferences = $data->pluck('nilai_preferensi')->filter()->toArray();
                $allPreferences = array_merge($allPreferences, $preferences);

                Log::info("Year $tahun stats:", $yearStats);
            }

            $summary = [
                'total_years' => count($comparison),
                'total_students' => $totalStudents,
                'total_tkj' => $totalTKJ,
                'total_tkr' => $totalTKR,
                'avg_preference' => !empty($allPreferences) ? array_sum($allPreferences) / count($allPreferences) : 0,
                'highest_preference' => !empty($allPreferences) ? max($allPreferences) : 0,
                'lowest_preference' => !empty($allPreferences) ? min($allPreferences) : 0
            ];

            $result = [
                'comparison' => $comparison,
                'tahun_ajaran' => $tahunAjaran,
                'summary' => $summary,
                'criteria' => $parameter['comparison_criteria'] ?? [],
                'data_availability' => $parameter['data_availability'] ?? []
            ];

            Log::info('Comparison report data processed successfully', [
                'years_count' => count($comparison),
                'total_students' => $totalStudents
            ]);

            return $result;
        } catch (\Exception $e) {
            Log::error('Error in getComparisonReportData: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return [
                'comparison' => [],
                'tahun_ajaran' => [],
                'summary' => [
                    'total_years' => 0,
                    'total_students' => 0,
                    'total_tkj' => 0,
                    'total_tkr' => 0,
                    'avg_preference' => 0
                ],
                'error' => $e->getMessage()
            ];
        }
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

            // Set options for better rendering
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'defaultFont' => 'Arial'
            ]);

            // Generate filename
            $filename = 'laporan_' . $laporan->laporan_id . '_' . time() . '.pdf';
            $filepath = 'reports/' . $filename;

            // Ensure directory exists
            if (!Storage::exists('reports')) {
                Storage::makeDirectory('reports');
            }

            // Save PDF to storage
            Storage::put($filepath, $pdf->output());

            // Update laporan with file path
            $laporan->update(['file_path' => $filepath]);

            return $filepath;
        } catch (\Exception $e) {
            Log::error('PDF Generation Error: ' . $e->getMessage());
            throw new \Exception('Gagal generate PDF: ' . $e->getMessage());
        }
    }
}
