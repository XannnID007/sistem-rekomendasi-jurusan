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
                'N1' => 0.02,
                'N2' => 0.02,
                'N3' => 0.02,
                'N4' => 0.02,
                'N5' => 0.02,
                'N6' => 0.02,
                'MA' => 0.03,
                'MB' => 0.39,
                'MC' => 0.03,
                'MD' => 0.03,
                'BB' => 0.39,
                'BP' => 0.01
            ];

            foreach ($defaultWeights as $kode => $bobot) {
                Kriteria::where('kode_kriteria', $kode)->update(['bobot' => $bobot]);
            }

            return redirect()
                ->route('admin.kriteria.index')
                ->with('success', 'Bobot kriteria berhasil direset ke nilai yang sesuai dengan perhitungan Excel');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal mereset bobot: ' . $e->getMessage());
        }
    }
}
