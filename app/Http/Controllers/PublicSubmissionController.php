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
            'penghasilan_ortu' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
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
                'penghasilan_ortu' => $validated['penghasilan_ortu'],
                'sudah_dihitung' => false,
                'status_submission' => 'pending',
                'tanggal_submission' => now(),
            ]);

            $this->topsisService->calculateTopsis($penilaian->penilaian_id);

            DB::commit();

            return redirect()->route('submission.result', $pesertaDidik->nisn)
                ->with('success', 'Data berhasil disubmit!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function result($nisn)
    {
        $pesertaDidik = PesertaDidik::where('nisn', $nisn)
            ->where('is_public_submission', true)
            ->firstOrFail();

        $pesertaDidik->load(['penilaianTerbaru', 'perhitunganTerbaru']);

        if (!$pesertaDidik->perhitunganTerbaru) {
            return redirect()->route('submission.index')->with('error', 'Hasil belum tersedia');
        }

        $perhitungan = $pesertaDidik->perhitunganTerbaru;
        $penilaian = $pesertaDidik->penilaianTerbaru;

        return view('public.submission.result', compact('pesertaDidik', 'perhitungan', 'penilaian'));
    }

    public function approve($nisn)
    {
        $pesertaDidik = PesertaDidik::where('nisn', $nisn)
            ->where('is_public_submission', true)
            ->firstOrFail();

        $penilaian = $pesertaDidik->penilaianTerbaru;

        $penilaian->update([
            'status_submission' => 'approved',
            'tanggal_approved' => now(),
        ]);

        $pesertaDidik->user->update(['is_active' => true]);

        return redirect()->route('submission.certificate', $nisn)
            ->with('success', 'Rekomendasi dikonfirmasi!');
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

        return redirect()->route('submission.certificate', $nisn)
            ->with('info', 'Pilihan dicatat. Admin akan menghubungi Anda.');
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
