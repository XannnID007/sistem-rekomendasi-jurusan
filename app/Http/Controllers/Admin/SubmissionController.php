<?php
// app/Http/Controllers/Admin/SubmissionController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PesertaDidik;
use App\Models\PenilaianPesertaDidik;
use App\Models\PerhitunganTopsis;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    /**
     * Tampilkan daftar submission dari public
     */
    public function index(Request $request)
    {
        $query = PesertaDidik::where('is_public_submission', true)
            ->with(['penilaianTerbaru', 'perhitunganTerbaru']);

        // Filter by status
        if ($request->filled('status')) {
            $query->whereHas('penilaianTerbaru', function ($q) use ($request) {
                $q->where('status_submission', $request->status);
            });
        }

        // Filter by jurusan rekomendasi
        if ($request->filled('jurusan')) {
            $query->whereHas('perhitunganTerbaru', function ($q) use ($request) {
                $q->where('jurusan_rekomendasi', $request->jurusan);
            });
        }

        // Filter by tahun ajaran
        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $submissions = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get statistics
        $stats = [
            'total' => PesertaDidik::where('is_public_submission', true)->count(),
            'pending' => PenilaianPesertaDidik::where('status_submission', 'pending')->count(),
            'approved' => PenilaianPesertaDidik::where('status_submission', 'approved')->count(),
            'rejected' => PenilaianPesertaDidik::where('status_submission', 'rejected')->count(),
        ];

        // Get filter options
        $tahunAjaran = PesertaDidik::where('is_public_submission', true)
            ->distinct()
            ->pluck('tahun_ajaran');

        return view('admin.submission.index', compact('submissions', 'stats', 'tahunAjaran'));
    }

    /**
     * Detail submission
     */
    public function show(PesertaDidik $pesertaDidik)
    {
        if (!$pesertaDidik->is_public_submission) {
            return redirect()->route('admin.submission.index')
                ->with('error', 'Data bukan dari public submission');
        }

        $pesertaDidik->load(['penilaianTerbaru', 'perhitunganTerbaru', 'user']);

        return view('admin.submission.show', compact('pesertaDidik'));
    }

    /**
     * Approve submission (admin override)
     */
    public function approve(PesertaDidik $pesertaDidik)
    {
        $penilaian = $pesertaDidik->penilaianTerbaru;

        if (!$penilaian) {
            return back()->with('error', 'Data penilaian tidak ditemukan');
        }

        $penilaian->update([
            'status_submission' => 'approved',
            'tanggal_approved' => now(),
        ]);

        $pesertaDidik->user->update(['is_active' => true]);

        return back()->with('success', 'Submission berhasil di-approve');
    }

    /**
     * Override jurusan (admin change recommendation)
     */
    public function overrideJurusan(Request $request, PesertaDidik $pesertaDidik)
    {
        $validated = $request->validate([
            'jurusan_baru' => 'required|in:TKJ,TKR',
            'catatan_admin' => 'nullable|string',
        ]);

        $perhitungan = $pesertaDidik->perhitunganTerbaru;
        $penilaian = $pesertaDidik->penilaianTerbaru;

        if (!$perhitungan || !$penilaian) {
            return back()->with('error', 'Data tidak lengkap');
        }

        // Update jurusan di perhitungan
        $perhitungan->update([
            'jurusan_rekomendasi' => $validated['jurusan_baru']
        ]);

        // Update status penilaian
        $penilaian->update([
            'status_submission' => 'approved',
            'jurusan_dipilih' => $validated['jurusan_baru'],
            'alasan_penolakan' => 'Diubah oleh admin: ' . ($validated['catatan_admin'] ?? 'Tidak ada catatan'),
            'tanggal_approved' => now(),
        ]);

        $pesertaDidik->user->update(['is_active' => true]);

        return back()->with('success', 'Jurusan berhasil diubah menjadi ' . $validated['jurusan_baru']);
    }

    /**
     * Delete submission
     */
    public function destroy(PesertaDidik $pesertaDidik)
    {
        if (!$pesertaDidik->is_public_submission) {
            return back()->with('error', 'Data bukan dari public submission');
        }

        try {
            // Delete user (akan cascade delete peserta didik)
            $pesertaDidik->user->delete();

            return redirect()->route('admin.submission.index')
                ->with('success', 'Submission berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    /**
     * Export submissions
     */
    public function export(Request $request)
    {
        $query = PesertaDidik::where('is_public_submission', true)
            ->with(['penilaianTerbaru', 'perhitunganTerbaru']);

        if ($request->filled('status')) {
            $query->whereHas('penilaianTerbaru', function ($q) use ($request) {
                $q->where('status_submission', $request->status);
            });
        }

        $submissions = $query->get();

        $filename = 'submissions_' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($submissions) {
            $file = fopen('php://output', 'w');

            // Header
            fputcsv($file, [
                'NISN',
                'Nama',
                'Email',
                'No. Telepon',
                'Tahun Ajaran',
                'Tanggal Submit',
                'Status',
                'Rekomendasi',
                'Nilai Preferensi',
                'Jurusan Dipilih',
                'Alasan'
            ]);

            // Data
            foreach ($submissions as $item) {
                $penilaian = $item->penilaianTerbaru;
                $perhitungan = $item->perhitunganTerbaru;

                fputcsv($file, [
                    $item->nisn,
                    $item->nama_lengkap,
                    $item->email_submission,
                    $item->no_telepon_submission,
                    $item->tahun_ajaran,
                    $penilaian ? $penilaian->tanggal_submission : '',
                    $penilaian ? ucfirst($penilaian->status_submission) : '',
                    $perhitungan ? $perhitungan->jurusan_rekomendasi : '',
                    $perhitungan ? $perhitungan->nilai_preferensi : '',
                    $penilaian ? $penilaian->jurusan_dipilih : '',
                    $penilaian ? $penilaian->alasan_penolakan : '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
