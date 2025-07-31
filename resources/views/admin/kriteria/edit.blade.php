@extends('layouts.admin')

@section('title', 'Edit Kriteria')
@section('page-title', 'Edit Kriteria')
@section('page-description', 'Edit kriteria: ' . $kriteria->nama_kriteria)

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-navy to-navy-dark">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gold rounded-full flex items-center justify-center">
                        <span class="text-navy font-bold">{{ $kriteria->kode_kriteria }}</span>
                    </div>
                    <div class="text-white">
                        <h3 class="text-lg font-semibold">Edit Kriteria</h3>
                        <p class="text-blue-100 text-sm">{{ $kriteria->nama_kriteria }}</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.kriteria.update', $kriteria) }}" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Kode Kriteria -->
                    <div>
                        <label for="kode_kriteria" class="block text-sm font-medium text-gray-700 mb-2">
                            Kode Kriteria <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="kode_kriteria" name="kode_kriteria"
                            value="{{ old('kode_kriteria', $kriteria->kode_kriteria) }}" maxlength="10"
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
                        <input type="text" id="nama_kriteria" name="nama_kriteria"
                            value="{{ old('nama_kriteria', $kriteria->nama_kriteria) }}"
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
                                    {{ old('jenis_kriteria', $kriteria->jenis_kriteria) === 'benefit' ? 'checked' : '' }}
                                    class="h-4 w-4 text-navy focus:ring-navy border-gray-300">
                                <label for="benefit" class="ml-3 block text-sm font-medium text-gray-700">
                                    Benefit (Keuntungan)
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input id="cost" name="jenis_kriteria" type="radio" value="cost"
                                    {{ old('jenis_kriteria', $kriteria->jenis_kriteria) === 'cost' ? 'checked' : '' }}
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
                            <input type="number" id="bobot" name="bobot"
                                value="{{ old('bobot', $kriteria->bobot) }}" min="0" max="1" step="0.0001"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('bobot') border-red-500 @enderror"
                                placeholder="0.1000" required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-sm"
                                    id="bobot-percent">{{ number_format($kriteria->bobot * 100, 2) }}%</span>
                            </div>
                        </div>
                        @error('bobot')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Nilai antara 0-1 (contoh: 0.1000 = 10%)</p>

                        <!-- Current Weight Display -->
                        <div class="mt-2 p-3 bg-blue-50 rounded-lg">
                            <div class="text-sm text-blue-800 mb-2">Bobot Saat Ini:
                                <strong>{{ $kriteria->bobot_persen }}</strong></div>
                            <div class="w-full bg-blue-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $kriteria->bobot * 100 }}%">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div>
                        <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                            Keterangan
                        </label>
                        <textarea id="keterangan" name="keterangan" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('keterangan') border-red-500 @enderror"
                            placeholder="Deskripsi atau penjelasan kriteria (opsional)">{{ old('keterangan', $kriteria->keterangan) }}</textarea>
                        @error('keterangan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <div class="flex items-center">
                            <input id="is_active" name="is_active" type="checkbox" value="1"
                                {{ old('is_active', $kriteria->is_active) ? 'checked' : '' }}
                                class="h-4 w-4 text-navy focus:ring-navy border-gray-300 rounded">
                            <label for="is_active" class="ml-3 block text-sm font-medium text-gray-700">
                                Aktifkan kriteria ini
                            </label>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Hanya kriteria aktif yang akan digunakan dalam perhitungan</p>

                        @if ($kriteria->is_active)
                            <div class="mt-2 p-2 bg-green-50 border border-green-200 rounded text-xs text-green-700">
                                ✓ Kriteria ini saat ini aktif dan digunakan dalam perhitungan TOPSIS
                            </div>
                        @else
                            <div class="mt-2 p-2 bg-red-50 border border-red-200 rounded text-xs text-red-700">
                                ⚠ Kriteria ini saat ini nonaktif dan tidak digunakan dalam perhitungan
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Warning About Changes -->
                <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                        <div>
                            <h4 class="font-medium text-yellow-800 mb-1">Peringatan Perubahan</h4>
                            <p class="text-sm text-yellow-700">
                                Perubahan pada kriteria ini akan mempengaruhi hasil perhitungan TOPSIS yang akan datang.
                                Hasil perhitungan sebelumnya tidak akan berubah secara otomatis.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.kriteria.show', $kriteria) }}"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-navy text-white rounded-lg hover:bg-navy-dark transition duration-200">
                        Simpan Perubahan
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
