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

    public function submit(Request $request)
    {
        Log::info('=== PUBLIC SUBMISSION START ===', ['nisn' => $request->nisn]);

        $request->validate([
            'nisn' => 'required|string|size:10'
        ], [
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.size' => 'NISN harus 10 digit.'
        ]);

        // Cek existing NISN
        $existingPeserta = PesertaDidik::where('nisn', $request->nisn)->first();
        if ($existingPeserta) {
            Log::info('Existing NISN found', ['nisn' => $existingPeserta->nisn]);
            return redirect()->route('submission.result', ['nisn' => $existingPeserta->nisn])
                ->with('info', 'NISN Anda sudah terdaftar. Berikut adalah hasil rekomendasi yang sudah ada.');
        }

        try {
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
                'nisn.unique' => 'NISN sudah terdaftar.',
                'email.unique' => 'Email sudah terdaftar.'
            ]);

            DB::beginTransaction();

            // Create user
            $user = User::create([
                'username' => $validated['nisn'],
                'email' => $validated['email'],
                'password' => Hash::make(Str::random(16)),
                'role' => 'student',
                'full_name' => $validated['nama_lengkap'],
                'is_active' => false,
            ]);

            Log::info('User created', ['user_id' => $user->user_id]);

            // Create peserta didik
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

            Log::info('Peserta didik created', ['peserta_didik_id' => $pesertaDidik->peserta_didik_id]);

            // Create penilaian
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

            // Calculate TOPSIS
            try {
                $this->topsisService->calculateTopsis($penilaian->penilaian_id);
                Log::info('TOPSIS calculation completed');
            } catch (\Exception $e) {
                Log::error('TOPSIS calculation failed', ['error' => $e->getMessage()]);
            }

            DB::commit();

            Log::info('=== PUBLIC SUBMISSION SUCCESS ===', ['nisn' => $pesertaDidik->nisn]);

            return redirect()->route('submission.result', ['nisn' => $pesertaDidik->nisn])
                ->with('success', 'Data berhasil disubmit! Silakan lihat hasil rekomendasi Anda.')
                ->with('newly_created_id', $pesertaDidik->peserta_didik_id);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput()
                ->with('error', 'Terdapat kesalahan dalam pengisian form. Silakan periksa kembali.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Submission failed', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Gagal memproses data: ' . $e->getMessage());
        }
    }

    public function result($nisn)
    {
        try {
            Log::info('=== RESULT PAGE ===', ['nisn' => $nisn]);

            $pesertaDidik = null;

            // Check from session first
            if (session()->has('newly_created_id')) {
                $pesertaDidik = PesertaDidik::find(session('newly_created_id'));
                Log::info('Found from session', ['id' => session('newly_created_id')]);
            }

            // If not in session, search by NISN (WITHOUT is_public_submission filter untuk debugging)
            if (!$pesertaDidik) {
                $pesertaDidik = PesertaDidik::where('nisn', $nisn)->first();
                Log::info('Search by NISN', [
                    'found' => $pesertaDidik ? 'yes' : 'no',
                    'is_public' => $pesertaDidik ? $pesertaDidik->is_public_submission : null
                ]);
            }

            if (!$pesertaDidik) {
                Log::error('Peserta not found', ['nisn' => $nisn]);
                return redirect()->route('submission.index')
                    ->with('error', 'Data peserta didik dengan NISN ' . $nisn . ' tidak ditemukan.');
            }

            $pesertaDidik->load(['penilaianTerbaru', 'perhitunganTerbaru']);
            $penilaian = $pesertaDidik->penilaianTerbaru;
            $perhitungan = $pesertaDidik->perhitunganTerbaru;

            // If no calculation, try to calculate
            if (!$perhitungan && $penilaian) {
                Log::info('No calculation, attempting to calculate');
                try {
                    $this->topsisService->calculateTopsis($penilaian->penilaian_id);
                    $pesertaDidik->load('perhitunganTerbaru');
                    $perhitungan = $pesertaDidik->perhitunganTerbaru;
                } catch (\Exception $e) {
                    Log::error('Calculation failed', ['error' => $e->getMessage()]);
                }
            }

            if (!$perhitungan) {
                return view('public.submission.result', [
                    'pesertaDidik' => $pesertaDidik,
                    'perhitungan' => null,
                    'penilaian' => $penilaian,
                    'error' => 'Hasil perhitungan sedang diproses. Silakan refresh halaman ini.'
                ]);
            }

            return view('public.submission.result', compact('pesertaDidik', 'perhitungan', 'penilaian'));
        } catch (\Exception $e) {
            Log::error('Result page error', ['error' => $e->getMessage()]);
            return redirect()->route('submission.index')
                ->with('error', 'Terjadi kesalahan saat memuat halaman hasil.');
        }
    }

    public function approve($nisn)
    {
        try {
            Log::info('=== APPROVE REQUEST ===', ['nisn' => $nisn, 'session_id' => session()->getId()]);

            // Cari peserta (TANPA filter is_public_submission dulu untuk debugging)
            $pesertaDidik = PesertaDidik::where('nisn', $nisn)->first();

            if (!$pesertaDidik) {
                Log::error('Peserta not found in database', ['nisn' => $nisn]);
                return redirect()->route('submission.index')
                    ->with('error', 'Data peserta didik dengan NISN ' . $nisn . ' tidak ditemukan.');
            }

            Log::info('Peserta found for approve', [
                'id' => $pesertaDidik->peserta_didik_id,
                'is_public' => $pesertaDidik->is_public_submission
            ]);

            $penilaian = $pesertaDidik->penilaianTerbaru;

            if (!$penilaian) {
                Log::error('Penilaian not found');
                return redirect()->route('submission.result', ['nisn' => $nisn])
                    ->with('error', 'Data penilaian tidak ditemukan');
            }

            // Update status
            $penilaian->update([
                'status_submission' => 'approved',
                'tanggal_approved' => now()
            ]);

            // Activate user
            $pesertaDidik->user->update(['is_active' => true]);

            Log::info('=== APPROVE SUCCESS ===', ['nisn' => $nisn]);

            // SIMPAN KE SESSION dengan key yang PERSISTENT
            session([
                'approved_nisn' => $nisn,
                'approved_peserta_id' => $pesertaDidik->peserta_didik_id
            ]);
            session()->save(); // PAKSA SAVE SESSION

            // REDIRECT TO CERTIFICATE
            return redirect()->route('submission.certificate', ['nisn' => $nisn])
                ->with('success', 'Rekomendasi berhasil dikonfirmasi!');
        } catch (\Exception $e) {
            Log::error('Approve failed', [
                'nisn' => $nisn,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('submission.result', ['nisn' => $nisn])
                ->with('error', 'Gagal menyetujui: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $nisn)
    {
        try {
            Log::info('=== REJECT REQUEST ===', ['nisn' => $nisn, 'session_id' => session()->getId()]);

            $validated = $request->validate([
                'alasan_penolakan' => 'required|string|min:10',
                'jurusan_dipilih' => 'required|in:TKJ,TKR'
            ]);

            // Cari peserta (TANPA filter is_public_submission dulu untuk debugging)
            $pesertaDidik = PesertaDidik::where('nisn', $nisn)->first();

            if (!$pesertaDidik) {
                Log::error('Peserta not found in database', ['nisn' => $nisn]);
                return redirect()->route('submission.index')
                    ->with('error', 'Data peserta didik dengan NISN ' . $nisn . ' tidak ditemukan.');
            }

            Log::info('Peserta found for reject', [
                'id' => $pesertaDidik->peserta_didik_id,
                'is_public' => $pesertaDidik->is_public_submission
            ]);

            $penilaian = $pesertaDidik->penilaianTerbaru;

            if (!$penilaian) {
                Log::error('Penilaian not found');
                return redirect()->route('submission.result', ['nisn' => $nisn])
                    ->with('error', 'Data penilaian tidak ditemukan');
            }

            // Update status
            $penilaian->update([
                'status_submission' => 'rejected',
                'alasan_penolakan' => $validated['alasan_penolakan'],
                'jurusan_dipilih' => $validated['jurusan_dipilih'],
                'tanggal_approved' => now(),
            ]);

            Log::info('=== REJECT SUCCESS ===', ['nisn' => $nisn]);

            // SIMPAN KE SESSION dengan key yang PERSISTENT
            session([
                'rejected_nisn' => $nisn,
                'rejected_peserta_id' => $pesertaDidik->peserta_didik_id
            ]);
            session()->save(); // PAKSA SAVE SESSION

            // REDIRECT TO CERTIFICATE
            return redirect()->route('submission.certificate', ['nisn' => $nisn])
                ->with('info', 'Pilihan Anda telah dicatat. Admin akan menghubungi Anda.');
        } catch (\Exception $e) {
            Log::error('Reject failed', [
                'nisn' => $nisn,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('submission.result', ['nisn' => $nisn])
                ->with('error', 'Gagal menolak: ' . $e->getMessage());
        }
    }

    public function certificate($nisn)
    {
        try {
            Log::info('=== CERTIFICATE PAGE ===', [
                'nisn' => $nisn,
                'session_id' => session()->getId(),
                'has_approved_session' => session()->has('approved_nisn'),
                'has_rejected_session' => session()->has('rejected_nisn')
            ]);

            $pesertaDidik = null;

            // Try multiple ways to find peserta
            // 1. From approve session
            if (session()->has('approved_peserta_id')) {
                $pesertaDidik = PesertaDidik::find(session('approved_peserta_id'));
                Log::info('Found from approve session', ['id' => session('approved_peserta_id')]);
            }

            // 2. From reject session
            if (!$pesertaDidik && session()->has('rejected_peserta_id')) {
                $pesertaDidik = PesertaDidik::find(session('rejected_peserta_id'));
                Log::info('Found from reject session', ['id' => session('rejected_peserta_id')]);
            }

            // 3. Search by NISN (WITHOUT is_public_submission untuk debugging)
            if (!$pesertaDidik) {
                $pesertaDidik = PesertaDidik::where('nisn', $nisn)->first();
                Log::info('Search by NISN', [
                    'found' => $pesertaDidik ? 'yes' : 'no',
                    'is_public' => $pesertaDidik ? $pesertaDidik->is_public_submission : null
                ]);
            }

            if (!$pesertaDidik) {
                Log::error('Peserta not found for certificate', [
                    'nisn' => $nisn,
                    'all_sessions' => session()->all()
                ]);

                // REDIRECT KE RESULT, BUKAN FORM!
                return redirect()->route('submission.result', ['nisn' => $nisn])
                    ->with('error', 'Data tidak ditemukan. Silakan coba lagi.');
            }

            $pesertaDidik->load(['penilaianTerbaru', 'perhitunganTerbaru']);
            $perhitungan = $pesertaDidik->perhitunganTerbaru;
            $penilaian = $pesertaDidik->penilaianTerbaru;

            Log::info('Certificate data loaded', [
                'has_perhitungan' => $perhitungan ? 'yes' : 'no',
                'has_penilaian' => $penilaian ? 'yes' : 'no'
            ]);

            return view('public.submission.certificate', compact('pesertaDidik', 'perhitungan', 'penilaian'));
        } catch (\Exception $e) {
            Log::error('Certificate page error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // REDIRECT KE RESULT, BUKAN FORM!
            return redirect()->route('submission.result', ['nisn' => $nisn])
                ->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    public function downloadPdf($nisn)
    {
        try {
            Log::info('=== PDF DOWNLOAD ===', ['nisn' => $nisn]);

            $pesertaDidik = PesertaDidik::where('nisn', $nisn)->first();

            if (!$pesertaDidik) {
                return redirect()->route('submission.result', ['nisn' => $nisn])
                    ->with('error', 'Data tidak ditemukan.');
            }

            $pesertaDidik->load(['penilaianTerbaru', 'perhitunganTerbaru']);
            $perhitungan = $pesertaDidik->perhitunganTerbaru;
            $penilaian = $pesertaDidik->penilaianTerbaru;

            $pdf = Pdf::loadView('public.submission.pdf', compact('pesertaDidik', 'perhitungan', 'penilaian'));

            Log::info('PDF generated');

            return $pdf->download('Hasil_Rekomendasi_' . $nisn . '.pdf');
        } catch (\Exception $e) {
            Log::error('PDF download failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Gagal mengunduh PDF: ' . $e->getMessage());
        }
    }
}
