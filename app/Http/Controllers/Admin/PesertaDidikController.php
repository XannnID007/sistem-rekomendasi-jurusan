<?php
// app/Http/Controllers/Admin/PesertaDidikController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PesertaDidik;
use App\Models\PenilaianPesertaDidik;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PesertaDidikController extends Controller
{
    /**
     * Display a listing of peserta didik
     */
    public function index(Request $request)
    {
        $query = PesertaDidik::with(['user', 'penilaianTerbaru', 'perhitunganTerbaru']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        // Filter by academic year
        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->get('tahun_ajaran'));
        }

        // Filter by gender
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->get('jenis_kelamin'));
        }

        $pesertaDidik = $query->orderBy('nama_lengkap')->paginate(15);

        // Get available academic years for filter
        $tahunAjaran = PesertaDidik::distinct()->pluck('tahun_ajaran');

        return view('admin.peserta-didik.index', compact('pesertaDidik', 'tahunAjaran'));
    }

    /**
     * Show the form for creating a new peserta didik
     */
    public function create()
    {
        return view('admin.peserta-didik.create');
    }

    /**
     * Store a newly created peserta didik
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nisn' => 'required|string|size:10|unique:peserta_didik,nisn',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date|before:today',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:15',
            'nama_orang_tua' => 'nullable|string|max:255',
            'no_telepon_orang_tua' => 'nullable|string|max:15',
            'tahun_ajaran' => 'required|string|max:9',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:6',
        ], [
            'nisn.required' => 'NISN wajib diisi',
            'nisn.size' => 'NISN harus 10 digit',
            'nisn.unique' => 'NISN sudah terdaftar',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini',
            'tahun_ajaran.required' => 'Tahun ajaran wajib diisi',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        DB::beginTransaction();
        try {
            // Create user account
            $user = User::create([
                'username' => $validated['nisn'],
                'email' => $validated['email'] ?? $validated['nisn'] . '@student.smkpenida2.sch.id',
                'password' => Hash::make($validated['password']),
                'role' => 'student',
                'full_name' => $validated['nama_lengkap'],
                'is_active' => true,
            ]);

            // Create peserta didik record
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
            ]);

            DB::commit();

            return redirect()
                ->route('admin.peserta-didik.index')
                ->with('success', 'Peserta didik berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan peserta didik: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified peserta didik
     */
    public function show(PesertaDidik $pesertaDidik)
    {
        $pesertaDidik->load(['user', 'penilaian', 'perhitunganTopsis']);

        return view('admin.peserta-didik.show', compact('pesertaDidik'));
    }

    /**
     * Show the form for editing peserta didik
     */
    public function edit(PesertaDidik $pesertaDidik)
    {
        $pesertaDidik->load('user');

        return view('admin.peserta-didik.edit', compact('pesertaDidik'));
    }

    /**
     * Update the specified peserta didik
     */
    public function update(Request $request, PesertaDidik $pesertaDidik)
    {
        $validated = $request->validate([
            'nisn' => ['required', 'string', 'size:10', Rule::unique('peserta_didik', 'nisn')->ignore($pesertaDidik->peserta_didik_id, 'peserta_didik_id')],
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date|before:today',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:15',
            'nama_orang_tua' => 'nullable|string|max:255',
            'no_telepon_orang_tua' => 'nullable|string|max:15',
            'tahun_ajaran' => 'required|string|max:9',
            'email' => ['nullable', 'email', Rule::unique('users', 'email')->ignore($pesertaDidik->user_id, 'user_id')],
            'password' => 'nullable|string|min:6',
            'is_active' => 'boolean',
        ], [
            'nisn.required' => 'NISN wajib diisi',
            'nisn.size' => 'NISN harus 10 digit',
            'nisn.unique' => 'NISN sudah terdaftar',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini',
            'tahun_ajaran.required' => 'Tahun ajaran wajib diisi',
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        DB::beginTransaction();
        try {
            // Update user account
            $userUpdateData = [
                'username' => $validated['nisn'],
                'email' => $validated['email'] ?? $validated['nisn'] . '@student.smkpenida2.sch.id',
                'full_name' => $validated['nama_lengkap'],
                'is_active' => $validated['is_active'] ?? true,
            ];

            if (!empty($validated['password'])) {
                $userUpdateData['password'] = Hash::make($validated['password']);
            }

            $pesertaDidik->user->update($userUpdateData);

            // Update peserta didik record
            $pesertaDidik->update([
                'nisn' => $validated['nisn'],
                'nama_lengkap' => $validated['nama_lengkap'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'alamat' => $validated['alamat'],
                'no_telepon' => $validated['no_telepon'],
                'nama_orang_tua' => $validated['nama_orang_tua'],
                'no_telepon_orang_tua' => $validated['no_telepon_orang_tua'],
                'tahun_ajaran' => $validated['tahun_ajaran'],
            ]);

            DB::commit();

            return redirect()
                ->route('admin.peserta-didik.show', $pesertaDidik)
                ->with('success', 'Data peserta didik berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui peserta didik: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified peserta didik
     */
    public function destroy(PesertaDidik $pesertaDidik)
    {
        DB::beginTransaction();
        try {
            // Delete related user account (will cascade delete peserta didik)
            $pesertaDidik->user->delete();

            DB::commit();

            return redirect()
                ->route('admin.peserta-didik.index')
                ->with('success', 'Peserta didik berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->with('error', 'Gagal menghapus peserta didik: ' . $e->getMessage());
        }
    }

    /**
     * Show form for creating penilaian
     */
    public function createPenilaian(PesertaDidik $pesertaDidik)
    {
        return view('admin.peserta-didik.penilaian.create', compact('pesertaDidik'));
    }

    /**
     * Store penilaian for peserta didik
     */
    public function storePenilaian(Request $request, PesertaDidik $pesertaDidik)
    {
        $validated = $request->validate([
            'tahun_ajaran' => 'required|string|max:9',
            'nilai_ipa' => 'required|numeric|min:0|max:100',
            'nilai_ips' => 'required|numeric|min:0|max:100',
            'nilai_matematika' => 'required|numeric|min:0|max:100',
            'nilai_bahasa_indonesia' => 'required|numeric|min:0|max:100',
            'nilai_bahasa_inggris' => 'required|numeric|min:0|max:100',
            'nilai_pkn' => 'required|numeric|min:0|max:100',
            'minat_a' => 'required|string|max:255',
            'minat_b' => 'required|string|max:255',
            'minat_c' => 'required|string|max:255',
            'minat_d' => 'required|string|max:255',
            'keahlian' => 'required|string|max:255',
            'biaya_gelombang' => 'required|string|max:50', // FIXED: Changed from penghasilan_ortu
        ], [
            'tahun_ajaran.required' => 'Tahun ajaran wajib diisi',
            'nilai_ipa.required' => 'Nilai IPA wajib diisi',
            'nilai_ipa.numeric' => 'Nilai IPA harus berupa angka',
            'nilai_ipa.min' => 'Nilai IPA minimal 0',
            'nilai_ipa.max' => 'Nilai IPA maksimal 100',
            'biaya_gelombang.required' => 'Biaya gelombang wajib dipilih', // FIXED
        ]);

        try {
            PenilaianPesertaDidik::create([
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
                'biaya_gelombang' => $validated['biaya_gelombang'], // FIXED
                'sudah_dihitung' => false,
            ]);

            return redirect()
                ->route('admin.peserta-didik.show', $pesertaDidik)
                ->with('success', 'Data penilaian berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan penilaian: ' . $e->getMessage());
        }
    }

    /**
     * Update penilaian
     */
    public function updatePenilaian(Request $request, PesertaDidik $pesertaDidik, PenilaianPesertaDidik $penilaian)
    {
        $validated = $request->validate([
            'tahun_ajaran' => 'required|string|max:9',
            'nilai_ipa' => 'required|numeric|min:0|max:100',
            'nilai_ips' => 'required|numeric|min:0|max:100',
            'nilai_matematika' => 'required|numeric|min:0|max:100',
            'nilai_bahasa_indonesia' => 'required|numeric|min:0|max:100',
            'nilai_bahasa_inggris' => 'required|numeric|min:0|max:100',
            'nilai_pkn' => 'required|numeric|min:0|max:100',
            'minat_a' => 'required|string|max:255',
            'minat_b' => 'required|string|max:255',
            'minat_c' => 'required|string|max:255',
            'minat_d' => 'required|string|max:255',
            'keahlian' => 'required|string|max:255',
            'biaya_gelombang' => 'required|string|max:50', // FIXED: Changed from penghasilan_ortu
        ]);

        try {
            $penilaian->update($validated);

            // Reset calculation status if data changed
            $penilaian->update(['sudah_dihitung' => false]);

            return redirect()
                ->route('admin.peserta-didik.show', $pesertaDidik)
                ->with('success', 'Data penilaian berhasil diperbarui');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui penilaian: ' . $e->getMessage());
        }
    }

    /**
     * Show form for editing penilaian
     */
    public function editPenilaian(PesertaDidik $pesertaDidik, PenilaianPesertaDidik $penilaian)
    {
        return view('admin.peserta-didik.penilaian.edit', compact('pesertaDidik', 'penilaian'));
    }

    /**
     * Delete penilaian
     */
    public function destroyPenilaian(PesertaDidik $pesertaDidik, PenilaianPesertaDidik $penilaian)
    {
        try {
            $penilaian->delete();

            return redirect()
                ->route('admin.peserta-didik.show', $pesertaDidik)
                ->with('success', 'Data penilaian berhasil dihapus');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal menghapus penilaian: ' . $e->getMessage());
        }
    }
}
