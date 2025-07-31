@extends('layouts.admin')

@section('title', 'Tambah Kriteria')
@section('page-title', 'Tambah Kriteria')
@section('page-description', 'Tambahkan kriteria baru untuk perhitungan TOPSIS')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-navy">Form Tambah Kriteria</h3>
                <p class="text-sm text-gray-600 mt-1">Lengkapi semua informasi kriteria</p>
            </div>

            <form method="POST" action="{{ route('admin.kriteria.store') }}" class="p-6">
                @csrf

                <div class="space-y-6">
                    <!-- Kode Kriteria -->
                    <div>
                        <label for="kode_kriteria" class="block text-sm font-medium text-gray-700 mb-2">
                            Kode Kriteria <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="kode_kriteria" name="kode_kriteria" value="{{ old('kode_kriteria') }}"
                            maxlength="10"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('kode_kriteria') border-red-500 @enderror"
                            placeholder="Contoh: K1, N1, MA" required>
                        @error('kode_kriteria')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Kode unik untuk mengidentifikasi kriteria (maksimal 10
                            karakter)</p>
                    </div>

                    <!-- Nama Kriteria -->
                    <div>
                        <label for="nama_kriteria" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Kriteria <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_kriteria" name="nama_kriteria" value="{{ old('nama_kriteria') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('nama_kriteria') border-red-500 @enderror"
                            placeholder="Contoh: Nilai Matematika" required>
                        @error('nama_kriteria')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Kriteria -->
                    <div>
                        <label for="jenis_kriteria" class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Kriteria <span class="text-red-500">*</span>
                        </label>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <input id="benefit" name="jenis_kriteria" type="radio" value="benefit"
                                    {{ old('jenis_kriteria', 'benefit') === 'benefit' ? 'checked' : '' }}
                                    class="h-4 w-4 text-navy focus:ring-navy border-gray-300">
                                <label for="benefit" class="ml-3 block text-sm font-medium text-gray-700">
                                    Benefit (Keuntungan)
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input id="cost" name="jenis_kriteria" type="radio" value="cost"
                                    {{ old('jenis_kriteria') === 'cost' ? 'checked' : '' }}
                                    class="h-4 w-4 text-navy focus:ring-navy border-gray-300">
                                <label for="cost" class="ml-3 block text-sm font-medium text-gray-700">
                                    Cost (Biaya)
                                </label>
                            </div>
                        </div>
                        @error('jenis_kriteria')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <div class="mt-2 text-xs text-gray-500 space-y-1">
                            <p><strong>Benefit:</strong> Semakin tinggi nilai semakin baik (contoh: nilai akademik, minat)
                            </p>
                            <p><strong>Cost:</strong> Semakin rendah nilai semakin baik (contoh: biaya, jarak)</p>
                        </div>
                    </div>

                    <!-- Bobot -->
                    <div>
                        <label for="bobot" class="block text-sm font-medium text-gray-700 mb-2">
                            Bobot Kriteria <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" id="bobot" name="bobot" value="{{ old('bobot') }}" min="0"
                                max="1" step="0.0001"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('bobot') border-red-500 @enderror"
                                placeholder="0.1000" required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-sm" id="bobot-percent">0%</span>
                            </div>
                        </div>
                        @error('bobot')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Nilai antara 0-1 (contoh: 0.1000 = 10%)</p>
                    </div>

                    <!-- Keterangan -->
                    <div>
                        <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                            Keterangan
                        </label>
                        <textarea id="keterangan" name="keterangan" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('keterangan') border-red-500 @enderror"
                            placeholder="Deskripsi atau penjelasan kriteria (opsional)">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <div class="flex items-center">
                            <input id="is_active" name="is_active" type="checkbox" value="1"
                                {{ old('is_active', true) ? 'checked' : '' }}
                                class="h-4 w-4 text-navy focus:ring-navy border-gray-300 rounded">
                            <label for="is_active" class="ml-3 block text-sm font-medium text-gray-700">
                                Aktifkan kriteria ini
                            </label>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Hanya kriteria aktif yang akan digunakan dalam perhitungan</p>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.kriteria.index') }}"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-navy text-white rounded-lg hover:bg-navy-dark transition duration-200">
                        Simpan Kriteria
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Update percentage display when bobot changes
            document.getElementById('bobot').addEventListener('input', function() {
                const value = parseFloat(this.value) || 0;
                const percentage = Math.round(value * 100 * 100) / 100; // Round to 2 decimal places
                document.getElementById('bobot-percent').textContent = percentage + '%';
            });

            // Convert kode kriteria to uppercase
            document.getElementById('kode_kriteria').addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
        </script>
    @endpush

@endsection
