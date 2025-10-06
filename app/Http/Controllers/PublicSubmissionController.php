<?php
// app/Http/Controllers/PublicSubmissionController.php

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

    public function submit(Request $request)
    {
        // Log untuk debugging
        Log::info('Submission attempt', [
            'data' => $request->all(),
            'method' => $request->method(),
            'url' => $request->url()
        ]);

        try {
            // Validasi input
            $validated = $request->validate([
                'nisn' => 'required|string|size:10|unique:peserta_didik,nisn',
                'nama_lengkap' => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:L,P',
                'tanggal_lahir' => 'required|date|before:today',
                'alamat' => 'required|string',
                'no_telepon' => 'required|string|max:15',
                'email' => 'required|email',
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
                // Custom error messages
                'nisn.required' => 'NISN wajib diisi',
                'nisn.size' => 'NISN harus 10 digit',
                'nisn.unique' => 'NISN sudah terdaftar dalam sistem',
                'email.email' => 'Format email tidak valid',
                'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini',
                'biaya_gelombang.required' => 'Biaya gelombang wajib dipilih',
                // ... tambahkan pesan error lainnya
            ]);

            Log::info('Validation passed', ['validated_data' => $validated]);

            DB::beginTransaction();

            // 1. Create User Account
            $user = User::create([
                'username' => $validated['nisn'],
                'email' => $validated['email'],
                'password' => Hash::make(Str::random(16)),
                'role' => 'student',
                'full_name' => $validated['nama_lengkap'],
                'is_active' => false, // Menunggu approval
            ]);

            Log::info('User created', ['user_id' => $user->user_id]);

            // 2. Create Peserta Didik Record
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

            Log::info('Peserta Didik created', ['peserta_didik_id' => $pesertaDidik->peserta_didik_id]);

            // 3. Create Penilaian Record
            $penilaian = PenilaianPesertaDidik::create([
                'peserta_didik_id' => $pesertaDidik->peserta_didik_id,
                'tahun_ajaran' => $validated['tahun_ajaran'],
                'nilai_ipa' => $validated['nilai_ipa'],
                'nilai_ips' => $validated['nilai_ips'],
                'nilai_matematika' => $validated['nilai_matematika'],
                'nilai_bahasa_indonesia' => $validated['nilai_bahasa_indonesia'],
                'nilai_bahasa_inggris' => $validated['nilai_bahasa_inggris'],
                'nilai_pkn' => $validated['nilai_pkn'],
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

            Log::info('Penilaian created', ['penilaian_id' => $penilaian->penilaian_id]);

            // 4. Calculate TOPSIS
            try {
                $result = $this->topsisService->calculateTopsis($penilaian->penilaian_id);
                Log::info('TOPSIS calculation success', ['result_count' => $result->count()]);
            } catch (\Exception $e) {
                Log::error('TOPSIS calculation failed but continuing', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                // Tidak throw error, tetap lanjut ke result page
            }

            DB::commit();

            Log::info('Transaction committed, redirecting to result');

            return redirect()
                ->route('submission.result', $pesertaDidik->nisn)
                ->with('success', 'Data berhasil disubmit! Silakan lihat hasil rekomendasi Anda.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors(),
                'input' => $request->except(['password'])
            ]);

            return back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Terdapat kesalahan dalam pengisian form. Silakan periksa kembali.');
        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Submission failed', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Gagal memproses data: ' . $e->getMessage());
        }
    }

    public function result($nisn)
    {
        try {
            $pesertaDidik = PesertaDidik::where('nisn', $nisn)
                ->where('is_public_submission', true)
                ->firstOrFail();

            $pesertaDidik->load(['penilaianTerbaru', 'perhitunganTerbaru']);

            if (!$pesertaDidik->perhitunganTerbaru) {
                Log::warning('No calculation found for NISN', ['nisn' => $nisn]);

                return view('public.submission.result', [
                    'pesertaDidik' => $pesertaDidik,
                    'perhitungan' => null,
                    'penilaian' => $pesertaDidik->penilaianTerbaru,
                    'error' => 'Perhitungan TOPSIS belum selesai. Silakan refresh halaman ini.'
                ]);
            }

            $perhitungan = $pesertaDidik->perhitunganTerbaru;
            $penilaian = $pesertaDidik->penilaianTerbaru;

            return view('public.submission.result', compact('pesertaDidik', 'perhitungan', 'penilaian'));
        } catch (\Exception $e) {
            Log::error('Error loading result page', [
                'nisn' => $nisn,
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->route('submission.index')
                ->with('error', 'Data tidak ditemukan atau terjadi kesalahan.');
        }
    }

    public function approve($nisn)
    {
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
    }

    public function reject(Request $request, $nisn)
    {
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
    }

    public function certificate($nisn)
    {
        $pesertaDidik = PesertaDidik::where('nisn', $nisn)
            ->where('is_public_submission', true)
            ->firstOrFail();

        $pesertaDidik->load(['penilaianTerbaru', 'perhitunganTerbaru']);
        $perhitungan = $pesertaDidik->perhitunganTerbaru;
        $penilaian = $pesertaDidik->penilaianTerbaru;

        return view('public.submission.certificate', compact('pesertaDidik', 'perhitungan', 'penilaian'));
    }

    public function downloadPdf($nisn)
    {
        $pesertaDidik = PesertaDidik::where('nisn', $nisn)
            ->where('is_public_submission', true)
            ->firstOrFail();

        $pesertaDidik->load(['penilaianTerbaru', 'perhitunganTerbaru']);
        $perhitungan = $pesertaDidik->perhitunganTerbaru;
        $penilaian = $pesertaDidik->penilaianTerbaru;

        $pdf = Pdf::loadView('public.submission.pdf', compact('pesertaDidik', 'perhitungan', 'penilaian'));

        return $pdf->download('Hasil_Rekomendasi_' . $nisn . '.pdf');
    }
}
