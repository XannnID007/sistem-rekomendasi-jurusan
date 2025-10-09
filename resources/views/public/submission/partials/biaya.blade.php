{{-- resources/views/public/submission/partials/biaya.blade.php --}}

<div class="md:col-span-2">
    <label for="biaya_gelombang" class="block text-sm font-medium text-gray-700">Pilihan Biaya Pendaftaran (Per
        Gelombang)</label>
    <select id="biaya_gelombang" name="biaya_gelombang" required
        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-navy focus:border-navy">
        <option value="">Pilih gelombang...</option>
        <option value="G1. 1.000.000" {{ old('biaya_gelombang') == 'G1. 1.000.000' ? 'selected' : '' }}>Gelombang 1 - Rp
            1.000.000</option>
        <option value="G2. 1.500.000" {{ old('biaya_gelombang') == 'G2. 1.500.000' ? 'selected' : '' }}>Gelombang 2 - Rp
            1.500.000</option>
        <option value="G3. 2.000.000" {{ old('biaya_gelombang') == 'G3. 2.000.000' ? 'selected' : '' }}>Gelombang 3 - Rp
            2.000.000</option>
        <option value="G4. 2.500.000" {{ old('biaya_gelombang') == 'G4. 2.500.000' ? 'selected' : '' }}>Gelombang 4 - Rp
            2.500.000</option>
    </select>
    <p class="mt-2 text-xs text-gray-500">Info: Mendaftar di gelombang lebih awal akan lebih hemat biaya.</p>
</div>
