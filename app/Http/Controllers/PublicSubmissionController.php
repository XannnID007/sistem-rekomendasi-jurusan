<?php

namespace App\Http\Controllers;

use App\Models\PesertaDidik;
use App\Models\PenilaianPesertaDidik;
use App\Models\User;
use App\Services\TopsisCalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class PublicSubmissionController extends Controller
{
    protected $topsisService;

    public function __construct(TopsisCalculationService $topsisService)
    {
        $this->topsisService = $topsisService;
    }

    public function index()
    {
        return view('public.submission.form');
    }

    /**
     * PERBAIKAN 1:
     * Logika submit diubah untuk menangani 2 skenario:
     * 1. Jika NISN sudah ada -> langsung redirect ke hasil.
     * 2. Jika NISN baru -> proses pendaftaran dan titipkan ID ke session.
     */
    public function submit(Request $request)
    {
        // Log untuk debugging
        Log::info('=== SUBMISSION START ===');
        Log::info('Request Data: ', $request->except(['password']));

        // Langkah 1: Validasi format NISN terlebih dahulu.
        $request->validate(
            ['nisn' => 'required|string|size:10'],
            ['nisn.required' => 'NISN wajib diisi.', 'nisn.size' => 'NISN harus 10 digit.']
        );

        // Langkah 2: Cek apakah NISN sudah terdaftar.
        $existingPeserta = PesertaDidik::where('nisn', $request->nisn)->first();

        if ($existingPeserta) {
            Log::info('NISN sudah terdaftar. Mengalihkan ke halaman hasil.', ['nisn' => $request->nisn]);
            return redirect()
                ->route('submission.result', ['nisn' => $existingPeserta->nisn])
                ->with('info', 'NISN Anda sudah terdaftar. Berikut adalah hasil rekomendasi yang sudah ada.');
        }

        // Langkah 3: Jika NISN baru, lanjutkan proses validasi dan pendaftaran.
        try {
            // Validasi input lengkap, termasuk 'unique' untuk memastikan tidak ada duplikasi.
            $validated = $request->validate([
                'nisn' => 'required|string|size:10|unique:peserta_didik,nisn',
                'nama_lengkap' => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:L,P',
                'tanggal_lahir' => 'required|date|before:today',
                'alamat' => 'required|string',
                'no_telepon' => 'required|string|max:15',
                'email' => 'required|email|unique:users,email',
                'nama_orang_tua' => 'required|string|max:255',
                'no_telepon_orang_tua' => 'required|string|max:15',
                'tahun_ajaran' => 'required|string|max:9',
                'nilai_ipa' => 'required|numeric|min:0|max:100',
                'nilai_ips' => 'required|numeric|min:0|max:100',
                'nilai_matematika' => 'required|numeric|min:0|max:100',
                'nilai_bahasa_indonesia' => 'required|numeric|min:0|max:100',
                'nilai_bahasa_inggris' => 'required|numeric|min:0|max:100',
                'nilai_pkn' => 'required|numeric|min:0|max:100',
                'minat_a' => 'required|string',
                'minat_b' => 'required|string',
                'minat_c' => 'required|string',
                'minat_d' => 'required|string',
                'keahlian' => 'required|string',
                'biaya_gelombang' => 'required|string',
            ], [
                'nisn.unique' => 'NISN sudah terdaftar dalam sistem.',
                'email.unique' => 'Email sudah terdaftar dalam sistem.',
                'email.email' => 'Format email tidak valid.',
                'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
                'biaya_gelombang.required' => 'Biaya gelombang wajib dipilih.',
            ]);

            Log::info('✓ Validasi untuk pengguna baru berhasil');

            DB::beginTransaction();
            Log::info('✓ Transaksi dimulai');

            $user = User::create([
                'username' => $validated['nisn'],
                'email' => $validated['email'],
                'password' => Hash::make(Str::random(16)), // Password acak, karena login tidak diperlukan untuk publik
                'role' => 'student',
                'full_name' => $validated['nama_lengkap'],
                'is_active' => false, // Diaktifkan setelah approve
            ]);

            $pesertaDidik = PesertaDidik::create([
                'user_id' => $user->user_id,
                'nisn' => $validated['nisn'],
                'nama_lengkap' => $validated['nama_lengkap'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'alamat' => $validated['alamat'],
                'no_telepon' => $validated['no_telepon'],
                'nama_orang_tua' => $validated['nama_orang_tua'],
                'no_telepon_orang_tua' => $validated['no_telepon_orang_tua'],
                'tahun_ajaran' => $validated['tahun_ajaran'],
                'is_public_submission' => true,
                'email_submission' => $validated['email'],
                'no_telepon_submission' => $validated['no_telepon'],
            ]);

            $penilaian = PenilaianPesertaDidik::create([
                'peserta_didik_id' => $pesertaDidik->peserta_didik_id,
                'tahun_ajaran' => $validated['tahun_ajaran'],
                'nilai_ipa' => $validated['nilai_ipa'],
                'nilai_ips' => $validated['nilai_ips'],
                'nilai_matematika' => $validated['matematika'],
                'nilai_bahasa_indonesia' => $validated['bahasa_indonesia'],
                'nilai_bahasa_inggris' => $validated['bahasa_inggris'],
                'nilai_pkn' => $validated['pkn'],
                'minat_a' => $validated['minat_a'],
                'minat_b' => $validated['minat_b'],
                'minat_c' => $validated['minat_c'],
                'minat_d' => $validated['minat_d'],
                'keahlian' => $validated['keahlian'],
                'biaya_gelombang' => $validated['biaya_gelombang'],
                'sudah_dihitung' => false,
                'status_submission' => 'pending',
                'tanggal_submission' => now(),
            ]);

            Log::info('✓ Data berhasil dibuat', ['peserta_didik_id' => $pesertaDidik->peserta_didik_id]);

            // Hitung TOPSIS
            $this->topsisService->calculateTopsis($penilaian->penilaian_id);
            Log::info('✓ Perhitungan TOPSIS selesai');

            DB::commit();
            Log::info('✓ Transaksi berhasil');

            // KUNCI PERBAIKAN: Titipkan ID yang baru dibuat ke session sebelum redirect.
            return redirect()
                ->route('submission.result', ['nisn' => $pesertaDidik->nisn])
                ->with('success', 'Data berhasil disubmit! Silakan lihat hasil rekomendasi Anda.')
                ->with('newly_created_id', $pesertaDidik->peserta_didik_id);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('✗ Validasi gagal', ['errors' => $e->errors()]);
            return back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Terdapat kesalahan dalam pengisian form. Silakan periksa kembali.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('✗✗✗ SUBMISSION GAGAL ✗✗✗', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()
                ->withInput()
                ->with('error', 'Gagal memproses data: ' . $e->getMessage());
        }
    }

    /**
     * PERBAIKAN 2:
     * Logika result diubah untuk mengatasi "race condition".
     * 1. Prioritaskan pencarian data berdasarkan ID dari session (untuk pendaftar baru).
     * 2. Jika tidak ada, baru cari berdasarkan NISN (untuk pengecekan ulang).
     */
    public function result($nisn)
    {
        Log::info('=== HALAMAN HASIL DIAKSES ===', ['nisn' => $nisn]);

        try {
            $pesertaDidik = null;

            // Prioritas 1: Cek "titipan" ID dari session. Ini paling andal untuk pendaftar baru.
            if (session()->has('newly_created_id')) {
                Log::info('Menemukan ID baru dari session, mencari berdasarkan ID.', ['id' => session('newly_created_id')]);
                $pesertaDidik = PesertaDidik::find(session('newly_created_id'));
            }

            // Prioritas 2 (Fallback): Jika tidak ada titipan, cari berdasarkan NISN.
            // Ini untuk pengguna yang ingin mengecek ulang hasilnya di lain waktu.
            if (!$pesertaDidik) {
                Log::info('Bukan pendaftaran baru, mencari berdasarkan NISN.', ['nisn' => $nisn]);
                $pesertaDidik = PesertaDidik::where('nisn', $nisn)
                    ->where('is_public_submission', true)
                    ->first();
            }

            // Jika dari kedua cara di atas tetap tidak ditemukan, baru tampilkan error.
            if (!$pesertaDidik) {
                Log::error('✗ Peserta didik tidak ditemukan setelah semua pengecekan', ['nisn' => $nisn]);
                return redirect()
                    ->route('submission.index')
                    ->with('error', 'Data peserta didik dengan NISN ' . $nisn . ' tidak ditemukan.');
            }

            Log::info('✓ Peserta didik ditemukan', ['peserta_didik_id' => $pesertaDidik->peserta_didik_id]);

            // Load relasi data
            $pesertaDidik->load(['penilaianTerbaru', 'perhitunganTerbaru']);
            $penilaian = $pesertaDidik->penilaianTerbaru;
            $perhitungan = $pesertaDidik->perhitunganTerbaru;

            // Pengaman: Jika perhitungan belum ter-load, coba lagi sekali.
            if (!$perhitungan && $penilaian) {
                Log::warning('Perhitungan tidak ditemukan, mencoba kalkulasi ulang...');
                $this->topsisService->calculateTopsis($penilaian->penilaian_id);
                $pesertaDidik->load('perhitunganTerbaru'); // Muat ulang relasi
                $perhitungan = $pesertaDidik->perhitunganTerbaru;
            }

            // Jika tetap tidak ada, tampilkan pesan sedang diproses.
            if (!$perhitungan) {
                Log::warning('Menampilkan halaman hasil tanpa data perhitungan.');
                return view('public.submission.result', [
                    'pesertaDidik' => $pesertaDidik,
                    'perhitungan' => null,
                    'penilaian' => $penilaian,
                    'error' => 'Hasil perhitungan sedang diproses. Silakan refresh halaman ini dalam beberapa detik.'
                ]);
            }

            Log::info('✓ Menampilkan halaman hasil lengkap');
            return view('public.submission.result', compact('pesertaDidik', 'perhitungan', 'penilaian'));
        } catch (\Exception $e) {
            Log::error('✗✗✗ ERROR MEMUAT HALAMAN HASIL ✗✗✗', ['nisn' => $nisn, 'error' => $e->getMessage()]);
            return redirect()
                ->route('submission.index')
                ->with('error', 'Terjadi kesalahan saat memuat halaman hasil: ' . $e->getMessage());
        }
    }


    // --- Method di bawah ini tidak perlu diubah ---

    public function approve($nisn)
    {
        try {
            $pesertaDidik = PesertaDidik::where('nisn', $nisn)
                ->where('is_public_submission', true)
                ->firstOrFail();

            $penilaian = $pesertaDidik->penilaianTerbaru;

            if (!$penilaian) {
                return back()->with('error', 'Data penilaian tidak ditemukan');
            }

            $penilaian->update([
                'status_submission' => 'approved',
                'tanggal_approved' => now(),
            ]);

            $pesertaDidik->user->update(['is_active' => true]);

            return redirect()
                ->route('submission.certificate', $nisn)
                ->with('success', 'Rekomendasi berhasil dikonfirmasi!');
        } catch (\Exception $e) {
            Log::error('Approve failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Gagal approve: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $nisn)
    {
        try {
            $validated = $request->validate([
                'alasan_penolakan' => 'required|string|min:10',
                'jurusan_dipilih' => 'required|in:TKJ,TKR',
            ]);

            $pesertaDidik = PesertaDidik::where('nisn', $nisn)
                ->where('is_public_submission', true)
                ->firstOrFail();

            $penilaian = $pesertaDidik->penilaianTerbaru;

            $penilaian->update([
                'status_submission' => 'rejected',
                'alasan_penolakan' => $validated['alasan_penolakan'],
                'jurusan_dipilih' => $validated['jurusan_dipilih'],
                'tanggal_approved' => now(),
            ]);

            return redirect()
                ->route('submission.certificate', $nisn)
                ->with('info', 'Pilihan Anda telah dicatat. Admin akan menghubungi Anda untuk konfirmasi lebih lanjut.');
        } catch (\Exception $e) {
            Log::error('Reject failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Gagal reject: ' . $e->getMessage());
        }
    }

    public function certificate($nisn)
    {
        try {
            $pesertaDidik = PesertaDidik::where('nisn', $nisn)
                ->where('is_public_submission', true)
                ->firstOrFail();

            $pesertaDidik->load(['penilaianTerbaru', 'perhitunganTerbaru']);
            $perhitungan = $pesertaDidik->perhitunganTerbaru;
            $penilaian = $pesertaDidik->penilaianTerbaru;

            return view('public.submission.certificate', compact('pesertaDidik', 'perhitungan', 'penilaian'));
        } catch (\Exception $e) {
            Log::error('Certificate failed', ['error' => $e->getMessage()]);
            return redirect()->route('submission.index')->with('error', 'Data tidak ditemukan');
        }
    }

    public function downloadPdf($nisn)
    {
        try {
            $pesertaDidik = PesertaDidik::where('nisn', $nisn)
                ->where('is_public_submission', true)
                ->firstOrFail();

            $pesertaDidik->load(['penilaianTerbaru', 'perhitunganTerbaru']);
            $perhitungan = $pesertaDidik->perhitunganTerbaru;
            $penilaian = $pesertaDidik->penilaianTerbaru;

            $pdf = Pdf::loadView('public.submission.pdf', compact('pesertaDidik', 'perhitungan', 'penilaian'));

            return $pdf->download('Hasil_Rekomendasi_' . $nisn . '.pdf');
        } catch (\Exception $e) {
            Log::error('PDF download failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Gagal download PDF: ' . $e->getMessage());
        }
    }
}
