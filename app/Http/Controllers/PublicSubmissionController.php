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
        Log::info('=== SUBMISSION START ===');
        $request->validate(['nisn' => 'required|string|size:10'], ['nisn.required' => 'NISN wajib diisi.', 'nisn.size' => 'NISN harus 10 digit.']);

        $existingPeserta = PesertaDidik::where('nisn', $request->nisn)->first();
        if ($existingPeserta) {
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
            ], ['nisn.unique' => 'NISN sudah terdaftar.', 'email.unique' => 'Email sudah terdaftar.']);

            DB::beginTransaction();

            $user = User::create([
                'username' => $validated['nisn'],
                'email' => $validated['email'],
                'password' => Hash::make(Str::random(16)),
                'role' => 'student',
                'full_name' => $validated['nama_lengkap'],
                'is_active' => false,
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

            $this->topsisService->calculateTopsis($penilaian->penilaian_id);

            DB::commit();

            return redirect()->route('submission.result', ['nisn' => $pesertaDidik->nisn])
                ->with('success', 'Data berhasil disubmit! Silakan lihat hasil rekomendasi Anda.')
                ->with('newly_created_id', $pesertaDidik->peserta_didik_id);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput()->with('error', 'Terdapat kesalahan dalam pengisian form. Silakan periksa kembali.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Gagal memproses data: ' . $e->getMessage());
        }
    }

    public function result($nisn)
    {
        try {
            $pesertaDidik = null;
            if (session()->has('newly_created_id')) {
                $pesertaDidik = PesertaDidik::find(session('newly_created_id'));
            }
            if (!$pesertaDidik) {
                $pesertaDidik = PesertaDidik::where('nisn', $nisn)->where('is_public_submission', true)->first();
            }
            if (!$pesertaDidik) {
                return redirect()->route('submission.index')->with('error', 'Data peserta didik dengan NISN ' . $nisn . ' tidak ditemukan.');
            }

            $pesertaDidik->load(['penilaianTerbaru', 'perhitunganTerbaru']);
            $penilaian = $pesertaDidik->penilaianTerbaru;
            $perhitungan = $pesertaDidik->perhitunganTerbaru;

            if (!$perhitungan && $penilaian) {
                $this->topsisService->calculateTopsis($penilaian->penilaian_id);
                $pesertaDidik->load('perhitunganTerbaru');
                $perhitungan = $pesertaDidik->perhitunganTerbaru;
            }

            if (!$perhitungan) {
                return view('public.submission.result', [
                    'pesertaDidik' => $pesertaDidik,
                    'perhitungan' => null,
                    'penilaian' => $penilaian,
                    'error' => 'Hasil perhitungan sedang diproses. Silakan refresh halaman ini dalam beberapa detik.'
                ]);
            }

            return view('public.submission.result', compact('pesertaDidik', 'perhitungan', 'penilaian'));
        } catch (\Exception $e) {
            return redirect()->route('submission.index')->with('error', 'Terjadi kesalahan saat memuat halaman hasil: ' . $e->getMessage());
        }
    }

    public function approve($nisn)
    {
        try {
            $pesertaDidik = PesertaDidik::where('nisn', $nisn)->where('is_public_submission', true)->firstOrFail();
            $penilaian = $pesertaDidik->penilaianTerbaru;
            if (!$penilaian) {
                return back()->with('error', 'Data penilaian tidak ditemukan');
            }

            $penilaian->update(['status_submission' => 'approved', 'tanggal_approved' => now()]);
            $pesertaDidik->user->update(['is_active' => true]);

            return redirect()->route('submission.certificate', ['nisn' => $nisn])
                ->with('success', 'Rekomendasi berhasil dikonfirmasi!')
                ->with('processed_peserta_id', $pesertaDidik->peserta_didik_id);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyetujui rekomendasi: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $nisn)
    {
        try {
            $validated = $request->validate(['alasan_penolakan' => 'required|string|min:10', 'jurusan_dipilih' => 'required|in:TKJ,TKR']);
            $pesertaDidik = PesertaDidik::where('nisn', $nisn)->where('is_public_submission', true)->firstOrFail();
            $penilaian = $pesertaDidik->penilaianTerbaru;
            if (!$penilaian) {
                return back()->with('error', 'Data penilaian tidak ditemukan');
            }

            $penilaian->update([
                'status_submission' => 'rejected',
                'alasan_penolakan' => $validated['alasan_penolakan'],
                'jurusan_dipilih' => $validated['jurusan_dipilih'],
                'tanggal_approved' => now(),
            ]);

            return redirect()->route('submission.certificate', ['nisn' => $nisn])
                ->with('info', 'Pilihan Anda telah dicatat. Admin akan menghubungi Anda untuk konfirmasi lebih lanjut.')
                ->with('processed_peserta_id', $pesertaDidik->peserta_didik_id);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menolak rekomendasi: ' . $e->getMessage());
        }
    }

    public function certificate($nisn)
    {
        try {
            $pesertaDidik = null;
            if (session()->has('processed_peserta_id')) {
                $pesertaDidik = PesertaDidik::find(session('processed_peserta_id'));
            }
            if (!$pesertaDidik) {
                $pesertaDidik = PesertaDidik::where('nisn', $nisn)->where('is_public_submission', true)->first();
            }
            if (!$pesertaDidik) {
                return redirect()->route('submission.index')->with('error', 'Data peserta didik tidak ditemukan.');
            }

            $pesertaDidik->load(['penilaianTerbaru', 'perhitunganTerbaru']);
            $perhitungan = $pesertaDidik->perhitunganTerbaru;
            $penilaian = $pesertaDidik->penilaianTerbaru;

            return view('public.submission.certificate', compact('pesertaDidik', 'perhitungan', 'penilaian'));
        } catch (\Exception $e) {
            return redirect()->route('submission.index')->with('error', 'Terjadi kesalahan saat memuat halaman sertifikat.');
        }
    }

    public function downloadPdf($nisn)
    {
        try {
            $pesertaDidik = PesertaDidik::where('nisn', $nisn)->where('is_public_submission', true)->firstOrFail();
            $pesertaDidik->load(['penilaianTerbaru', 'perhitunganTerbaru']);
            $perhitungan = $pesertaDidik->perhitunganTerbaru;
            $penilaian = $pesertaDidik->penilaianTerbaru;
            $pdf = Pdf::loadView('public.submission.pdf', compact('pesertaDidik', 'perhitungan', 'penilaian'));
            return $pdf->download('Hasil_Rekomendasi_' . $nisn . '.pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengunduh PDF: ' . $e->getMessage());
        }
    }
}
