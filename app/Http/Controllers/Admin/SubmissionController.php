<?php
// app/Http/Controllers/Admin/SubmissionController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PesertaDidik;
use App\Models\PenilaianPesertaDidik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubmissionController extends Controller
{
    /**
     * Tampilkan daftar submission dari public
     */
    public function index(Request $request)
    {
        // =================================================================
        // PERUBAHAN UTAMA DI SINI
        // =================================================================
        // Query dimulai dari PenilaianPesertaDidik, bukan PesertaDidik.
        // Ini memastikan setiap entri penilaian baru akan terambil.
        $query = PenilaianPesertaDidik::query()
            ->with(['pesertaDidik.user', 'pesertaDidik.perhitunganTerbaru'])
            ->whereHas('pesertaDidik', function ($q) {
                // Filter hanya untuk submission dari halaman publik
                $q->where('is_public_submission', true);
            });


        // Filter by status (sekarang langsung ke kolom di tabel penilaian)
        if ($request->filled('status')) {
            $query->where('status_submission', $request->status);
        }

        // Filter by jurusan rekomendasi (melalui relasi pesertaDidik)
        if ($request->filled('jurusan')) {
            $query->whereHas('pesertaDidik.perhitunganTerbaru', function ($q) use ($request) {
                $q->where('jurusan_rekomendasi', $request->jurusan);
            });
        }

        // Filter by tahun ajaran (langsung ke kolom di tabel penilaian)
        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }

        // Search (melalui relasi pesertaDidik)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('pesertaDidik', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        // Mengurutkan berdasarkan data penilaian yang terbaru
        $submissions = $query->latest('tanggal_submission')->paginate(20);

        // Get statistics
        $statsQuery = function ($status) {
            return PenilaianPesertaDidik::where('status_submission', $status)
                ->whereHas('pesertaDidik', fn($q) => $q->where('is_public_submission', true))
                ->count();
        };

        $stats = [
            'total' => PenilaianPesertaDidik::whereHas('pesertaDidik', fn($q) => $q->where('is_public_submission', true))->count(),
            'pending' => $statsQuery('pending'),
            'approved' => $statsQuery('approved'),
            'rejected' => $statsQuery('rejected'),
        ];

        // Get filter options
        $tahunAjaran = PenilaianPesertaDidik::whereHas('pesertaDidik', fn($q) => $q->where('is_public_submission', true))
            ->distinct()
            ->pluck('tahun_ajaran')
            ->filter();

        return view('admin.submission.index', compact('submissions', 'stats', 'tahunAjaran'));
    }

    /**
     * Detail submission
     */
    public function show($id) // Menggunakan ID Penilaian
    {
        $penilaian = PenilaianPesertaDidik::with(['pesertaDidik.user', 'pesertaDidik.perhitunganTerbaru'])
            ->findOrFail($id);

        $pesertaDidik = $penilaian->pesertaDidik;

        return view('admin.submission.show', compact('penilaian', 'pesertaDidik'));
    }

    /**
     * Approve submission (admin override)
     */
    public function approve($id) // Menggunakan ID Penilaian
    {
        $penilaian = PenilaianPesertaDidik::with('pesertaDidik.user')->findOrFail($id);

        $penilaian->update([
            'status_submission' => 'approved',
            'tanggal_approved' => now(),
        ]);

        $penilaian->pesertaDidik->user->update(['is_active' => true]);

        Log::info('Submission approved by admin', ['penilaian_id' => $id]);

        return back()->with('success', 'Submission berhasil di-approve');
    }

    /**
     * Override jurusan (admin change recommendation)
     */
    public function overrideJurusan(Request $request, $id) // Menggunakan ID Penilaian
    {
        $validated = $request->validate([
            'jurusan_baru' => 'required|in:TKJ,TKR',
            'catatan_admin' => 'nullable|string',
        ]);

        $penilaian = PenilaianPesertaDidik::with('pesertaDidik.user', 'pesertaDidik.perhitunganTerbaru')->findOrFail($id);
        $perhitungan = $penilaian->pesertaDidik->perhitunganTerbaru;

        if (!$perhitungan) {
            return back()->with('error', 'Data perhitungan tidak ditemukan');
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

        $penilaian->pesertaDidik->user->update(['is_active' => true]);

        return back()->with('success', 'Jurusan berhasil diubah menjadi ' . $validated['jurusan_baru']);
    }

    /**
     * Delete submission
     */
    public function destroy($id) // Menggunakan ID Penilaian
    {
        try {
            $penilaian = PenilaianPesertaDidik::with('pesertaDidik.user')->findOrFail($id);
            // Hapus user, dan data lain (peserta, penilaian, perhitungan) akan terhapus otomatis karena cascade delete
            if ($penilaian->pesertaDidik->user) {
                $penilaian->pesertaDidik->user->delete();
            } else {
                // Jika user tidak ada, hapus manual
                $penilaian->pesertaDidik->delete();
            }

            return redirect()->route('admin.submission.index')
                ->with('success', 'Submission berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus submission', ['error' => $e->getMessage()]);
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}
