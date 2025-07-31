<?php
// app/Http/Controllers/Admin/KriteriaController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    /**
     * Display a listing of criteria
     */
    public function index()
    {
        $kriteria = Kriteria::orderBy('kode_kriteria')->get();

        // Calculate total weight
        $totalBobot = $kriteria->sum('bobot');

        // Group criteria by category for better display
        $kriteriaGrouped = [
            'Nilai Akademik' => $kriteria->whereIn('kode_kriteria', ['N1', 'N2', 'N3', 'N4', 'N5', 'N6']),
            'Minat' => $kriteria->whereIn('kode_kriteria', ['MA', 'MB', 'MC', 'MD']),
            'Lainnya' => $kriteria->whereIn('kode_kriteria', ['BB', 'BP'])
        ];

        return view('admin.kriteria.index', compact('kriteria', 'totalBobot', 'kriteriaGrouped'));
    }

    /**
     * Show the form for creating a new criteria
     */
    public function create()
    {
        return view('admin.kriteria.create');
    }

    /**
     * Store a newly created criteria
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_kriteria' => 'required|string|max:10|unique:kriteria,kode_kriteria',
            'nama_kriteria' => 'required|string|max:255',
            'jenis_kriteria' => 'required|in:benefit,cost',
            'bobot' => 'required|numeric|min:0|max:1',
            'keterangan' => 'nullable|string',
            'is_active' => 'boolean'
        ], [
            'kode_kriteria.required' => 'Kode kriteria wajib diisi',
            'kode_kriteria.unique' => 'Kode kriteria sudah digunakan',
            'nama_kriteria.required' => 'Nama kriteria wajib diisi',
            'jenis_kriteria.required' => 'Jenis kriteria wajib dipilih',
            'jenis_kriteria.in' => 'Jenis kriteria harus benefit atau cost',
            'bobot.required' => 'Bobot wajib diisi',
            'bobot.numeric' => 'Bobot harus berupa angka',
            'bobot.min' => 'Bobot minimal 0',
            'bobot.max' => 'Bobot maksimal 1',
        ]);

        try {
            Kriteria::create([
                'kode_kriteria' => strtoupper($validated['kode_kriteria']),
                'nama_kriteria' => $validated['nama_kriteria'],
                'jenis_kriteria' => $validated['jenis_kriteria'],
                'bobot' => $validated['bobot'],
                'keterangan' => $validated['keterangan'],
                'is_active' => $validated['is_active'] ?? true,
            ]);

            return redirect()
                ->route('admin.kriteria.index')
                ->with('success', 'Kriteria berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan kriteria: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified criteria
     */
    public function show(Kriteria $kriteria)
    {
        return view('admin.kriteria.show', compact('kriteria'));
    }

    /**
     * Show the form for editing the specified criteria
     */
    public function edit(Kriteria $kriteria)
    {
        return view('admin.kriteria.edit', compact('kriteria'));
    }

    /**
     * Update the specified criteria
     */
    public function update(Request $request, Kriteria $kriteria)
    {
        $validated = $request->validate([
            'kode_kriteria' => 'required|string|max:10|unique:kriteria,kode_kriteria,' . $kriteria->kriteria_id . ',kriteria_id',
            'nama_kriteria' => 'required|string|max:255',
            'jenis_kriteria' => 'required|in:benefit,cost',
            'bobot' => 'required|numeric|min:0|max:1',
            'keterangan' => 'nullable|string',
            'is_active' => 'boolean'
        ], [
            'kode_kriteria.required' => 'Kode kriteria wajib diisi',
            'kode_kriteria.unique' => 'Kode kriteria sudah digunakan',
            'nama_kriteria.required' => 'Nama kriteria wajib diisi',
            'jenis_kriteria.required' => 'Jenis kriteria wajib dipilih',
            'jenis_kriteria.in' => 'Jenis kriteria harus benefit atau cost',
            'bobot.required' => 'Bobot wajib diisi',
            'bobot.numeric' => 'Bobot harus berupa angka',
            'bobot.min' => 'Bobot minimal 0',
            'bobot.max' => 'Bobot maksimal 1',
        ]);

        try {
            $kriteria->update([
                'kode_kriteria' => strtoupper($validated['kode_kriteria']),
                'nama_kriteria' => $validated['nama_kriteria'],
                'jenis_kriteria' => $validated['jenis_kriteria'],
                'bobot' => $validated['bobot'],
                'keterangan' => $validated['keterangan'],
                'is_active' => $validated['is_active'] ?? true,
            ]);

            return redirect()
                ->route('admin.kriteria.show', $kriteria)
                ->with('success', 'Kriteria berhasil diperbarui');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui kriteria: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified criteria
     */
    public function destroy(Kriteria $kriteria)
    {
        try {
            // Check if criteria is used in calculations
            // You might want to add this check

            $kriteria->delete();

            return redirect()
                ->route('admin.kriteria.index')
                ->with('success', 'Kriteria berhasil dihapus');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal menghapus kriteria: ' . $e->getMessage());
        }
    }

    /**
     * Reset weights to default values
     */
    public function resetWeights()
    {
        try {
            $defaultWeights = [
                'N1' => 0.0500,
                'N2' => 0.0500,
                'N3' => 0.0500,
                'N4' => 0.0500,
                'N5' => 0.0500,
                'N6' => 0.0500,
                'MA' => 0.1000,
                'MB' => 0.1500,
                'MC' => 0.1000,
                'MD' => 0.0500,
                'BB' => 0.2000,
                'BP' => 0.1000
            ];

            foreach ($defaultWeights as $kode => $bobot) {
                Kriteria::where('kode_kriteria', $kode)->update(['bobot' => $bobot]);
            }

            return redirect()
                ->route('admin.kriteria.index')
                ->with('success', 'Bobot kriteria berhasil direset ke nilai default');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal mereset bobot: ' . $e->getMessage());
        }
    }
}
