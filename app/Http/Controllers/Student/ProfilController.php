<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
    /**
     * Display student profile
     */
    public function index()
    {
        $user = auth()->user();
        $pesertaDidik = $user->pesertaDidik;

        if (!$pesertaDidik) {
            return redirect()->route('login')->with('error', 'Data peserta didik tidak ditemukan');
        }

        // Load latest assessment and calculation
        $pesertaDidik->load(['penilaianTerbaru', 'perhitunganTerbaru']);

        // Calculate profile completion
        $profileCompletion = $this->calculateProfileCompletion($pesertaDidik);

        // Get account activity
        $accountActivity = $this->getAccountActivity($user);

        return view('student.profil.index', compact(
            'user',
            'pesertaDidik',
            'profileCompletion',
            'accountActivity'
        ));
    }

    /**
     * Show profile edit form
     */
    public function edit()
    {
        $user = auth()->user();
        $pesertaDidik = $user->pesertaDidik;

        if (!$pesertaDidik) {
            return redirect()->route('login')->with('error', 'Data peserta didik tidak ditemukan');
        }

        return view('student.profil.edit', compact('user', 'pesertaDidik'));
    }

    /**
     * Update profile
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        $pesertaDidik = $user->pesertaDidik;

        if (!$pesertaDidik) {
            return redirect()->route('login')->with('error', 'Data peserta didik tidak ditemukan');
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->user_id, 'user_id')],
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:15',
            'nama_orang_tua' => 'nullable|string|max:255',
            'no_telepon_orang_tua' => 'nullable|string|max:15',
        ], [
            'full_name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'no_telepon.max' => 'Nomor telepon maksimal 15 karakter',
            'no_telepon_orang_tua.max' => 'Nomor telepon orang tua maksimal 15 karakter',
        ]);

        try {
            // Update user data
            $user->update([
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
            ]);

            // Update peserta didik data
            $pesertaDidik->update([
                'nama_lengkap' => $validated['full_name'],
                'alamat' => $validated['alamat'],
                'no_telepon' => $validated['no_telepon'],
                'nama_orang_tua' => $validated['nama_orang_tua'],
                'no_telepon_orang_tua' => $validated['no_telepon_orang_tua'],
            ]);

            return redirect()
                ->route('student.profil.index')
                ->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }

    /**
     * Show password change form
     */
    public function password()
    {
        return view('student.profil.password');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'password.required' => 'Password baru wajib diisi',
            'password.min' => 'Password baru minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        // Check current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Password saat ini tidak benar']);
        }

        try {
            $user->update([
                'password' => Hash::make($validated['password'])
            ]);

            return redirect()
                ->route('student.profil.index')
                ->with('success', 'Password berhasil diperbarui');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal memperbarui password: ' . $e->getMessage());
        }
    }

    /**
     * Calculate profile completion percentage
     */
    private function calculateProfileCompletion($pesertaDidik)
    {
        $requiredFields = [
            'nisn' => $pesertaDidik->nisn,
            'nama_lengkap' => $pesertaDidik->nama_lengkap,
            'jenis_kelamin' => $pesertaDidik->jenis_kelamin,
            'tanggal_lahir' => $pesertaDidik->tanggal_lahir,
            'tahun_ajaran' => $pesertaDidik->tahun_ajaran,
        ];

        $optionalFields = [
            'alamat' => $pesertaDidik->alamat,
            'no_telepon' => $pesertaDidik->no_telepon,
            'nama_orang_tua' => $pesertaDidik->nama_orang_tua,
            'no_telepon_orang_tua' => $pesertaDidik->no_telepon_orang_tua,
        ];

        // Count required fields (always 100% if account exists)
        $requiredCompleted = count(array_filter($requiredFields, function ($value) {
            return !empty($value);
        }));

        // Count optional fields
        $optionalCompleted = count(array_filter($optionalFields, function ($value) {
            return !empty($value);
        }));

        $totalFields = count($requiredFields) + count($optionalFields);
        $completedFields = $requiredCompleted + $optionalCompleted;

        $percentage = round(($completedFields / $totalFields) * 100);

        return [
            'percentage' => $percentage,
            'completed_fields' => $completedFields,
            'total_fields' => $totalFields,
            'missing_fields' => $this->getMissingFields($optionalFields)
        ];
    }

    /**
     * Get missing optional fields
     */
    private function getMissingFields($optionalFields)
    {
        $missing = [];
        $fieldLabels = [
            'alamat' => 'Alamat',
            'no_telepon' => 'Nomor Telepon',
            'nama_orang_tua' => 'Nama Orang Tua',
            'no_telepon_orang_tua' => 'Nomor Telepon Orang Tua'
        ];

        foreach ($optionalFields as $field => $value) {
            if (empty($value)) {
                $missing[] = $fieldLabels[$field];
            }
        }

        return $missing;
    }

    /**
     * Get account activity information
     */
    private function getAccountActivity($user)
    {
        return [
            'last_login' => $user->updated_at, // Simplified - you can track actual login times
            'account_created' => $user->created_at,
            'total_logins' => 'N/A', // You can implement login tracking
            'account_status' => $user->is_active ? 'Aktif' : 'Nonaktif'
        ];
    }
}
