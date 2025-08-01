@extends('layouts.admin')

@section('title', 'Edit Perhitungan TOPSIS')
@section('page-title', 'Edit Perhitungan TOPSIS')
@section('page-description', $perhitungan->pesertaDidik->nama_lengkap . ' - ' . $perhitungan->pesertaDidik->nisn)

@section('content')
    <div class="space-y-6">
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.perhitungan.index') }}"
                    class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-lg font-semibold text-navy">Edit Perhitungan TOPSIS</h2>
                    <p class="text-sm text-gray-600">{{ $perhitungan->pesertaDidik->nama_lengkap }} - NISN:
                        {{ $perhitungan->pesertaDidik->nisn }}</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.perhitungan.show', $perhitungan) }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Lihat Detail
                </a>
            </div>
        </div>

        <!-- Warning Card -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
            <div class="flex items-start space-x-3">
                <svg class="w-6 h-6 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
                <div>
                    <h4 class="font-medium text-yellow-800 mb-2">Peringatan Penting</h4>
                    <div class="text-sm text-yellow-700 space-y-2">
                        <p>• Mengedit perhitungan TOPSIS akan mengubah hasil rekomendasi yang sudah ada</p>
                        <p>• Pastikan data yang dimasukkan sudah benar dan akurat</p>
                        <p>• Perubahan ini akan mempengaruhi ranking siswa lain dalam tahun ajaran yang sama</p>
                        <p>• Disarankan untuk membuat backup data sebelum melakukan perubahan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <form method="POST" action="{{ route('admin.perhitungan.update', $perhitungan) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Student Info Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-navy mb-4">Informasi Peserta Didik</h3>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" value="{{ $perhitungan->pesertaDidik->nama_lengkap }}" disabled
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NISN</label>
                            <input type="text" value="{{ $perhitungan->pesertaDidik->nisn }}" disabled
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600">
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700 mb-1">Tahun
                                Ajaran</label>
                            <input type="text" name="tahun_ajaran" id="tahun_ajaran"
                                value="{{ old('tahun_ajaran', $perhitungan->tahun_ajaran) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent"
                                required>
                            @error('tahun_ajaran')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Perhitungan</label>
                            <input type="text" value="{{ $perhitungan->tanggal_perhitungan->format('d/m/Y H:i') }}"
                                disabled
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Results Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-navy mb-4">Hasil Perhitungan Saat Ini</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-blue-800 mb-1">Jarak ke Solusi Positif</label>
                        <div class="text-2xl font-bold text-blue-600">{{ number_format($perhitungan->jarak_positif, 6) }}
                        </div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-purple-800 mb-1">Jarak ke Solusi Negatif</label>
                        <div class="text-2xl font-bold text-purple-600">{{ number_format($perhitungan->jarak_negatif, 6) }}
                        </div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-green-800 mb-1">Nilai Preferensi</label>
                        <div class="text-2xl font-bold text-green-600">
                            {{ number_format($perhitungan->nilai_preferensi, 6) }}</div>
                        <div class="text-sm text-green-700 mt-1">
                            Rekomendasi: <span class="font-semibold">{{ $perhitungan->jurusan_rekomendasi }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Values Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-navy mb-4">Edit Nilai Perhitungan</h3>
                <p class="text-sm text-gray-600 mb-6">Sesuaikan nilai jika diperlukan. Sistem akan otomatis menghitung ulang
                    nilai preferensi dan rekomendasi.</p>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Jarak Solusi -->
                    <div class="space-y-4">
                        <h4 class="font-semibold text-gray-900">Jarak Solusi</h4>

                        <div>
                            <label for="jarak_positif" class="block text-sm font-medium text-gray-700 mb-1">
                                Jarak ke Solusi Positif (D+)
                            </label>
                            <input type="number" name="jarak_positif" id="jarak_positif" step="0.000001"
                                value="{{ old('jarak_positif', $perhitungan->jarak_positif) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent"
                                required>
                            @error('jarak_positif')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="jarak_negatif" class="block text-sm font-medium text-gray-700 mb-1">
                                Jarak ke Solusi Negatif (D-)
                            </label>
                            <input type="number" name="jarak_negatif" id="jarak_negatif" step="0.000001"
                                value="{{ old('jarak_negatif', $perhitungan->jarak_negatif) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent"
                                required>
                            @error('jarak_negatif')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Rekomendasi Manual -->
                    <div class="space-y-4">
                        <h4 class="font-semibold text-gray-900">Rekomendasi</h4>

                        <div>
                            <label for="nilai_preferensi" class="block text-sm font-medium text-gray-700 mb-1">
                                Nilai Preferensi (Manual)
                            </label>
                            <input type="number" name="nilai_preferensi" id="nilai_preferensi" step="0.000001"
                                min="0" max="1"
                                value="{{ old('nilai_preferensi', $perhitungan->nilai_preferensi) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent"
                                required>
                            @error('nilai_preferensi')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Nilai antara 0 dan 1. > 0.30 = TKJ, ≤ 0.30 = TKR</p>
                        </div>

                        <div>
                            <label for="jurusan_rekomendasi" class="block text-sm font-medium text-gray-700 mb-1">
                                Jurusan Rekomendasi
                            </label>
                            <select name="jurusan_rekomendasi" id="jurusan_rekomendasi"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent"
                                required>
                                <option value="TKJ"
                                    {{ old('jurusan_rekomendasi', $perhitungan->jurusan_rekomendasi) === 'TKJ' ? 'selected' : '' }}>
                                    TKJ (Teknik Komputer dan Jaringan)
                                </option>
                                <option value="TKR"
                                    {{ old('jurusan_rekomendasi', $perhitungan->jurusan_rekomendasi) === 'TKR' ? 'selected' : '' }}>
                                    TKR (Teknik Kendaraan Ringan)
                                </option>
                            </select>
                            @error('jurusan_rekomendasi')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Auto Calculate Button -->
                        <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                            <button type="button" id="auto-calculate"
                                class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-200">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                Hitung Otomatis
                            </button>
                            <p class="text-xs text-gray-500 mt-2">Klik untuk menghitung ulang nilai preferensi berdasarkan
                                jarak solusi</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <button type="submit"
                    class="flex-1 bg-navy text-white px-6 py-3 rounded-lg hover:bg-navy-dark transition duration-200 font-medium">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.perhitungan.show', $perhitungan) }}"
                    class="flex-1 bg-white border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition duration-200 text-center font-medium">
                    Batal
                </a>
                <button type="button" onclick="resetForm()"
                    class="flex-1 bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition duration-200 font-medium">
                    Reset
                </button>
            </div>
        </form>

        <!-- Information Card -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
            <div class="flex items-start space-x-3">
                <svg class="w-6 h-6 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h4 class="font-medium text-blue-800 mb-2">Informasi Perhitungan TOPSIS</h4>
                    <div class="text-sm text-blue-700 space-y-2">
                        <p>• <strong>Nilai Preferensi:</strong> Dihitung menggunakan rumus C = D- / (D+ + D-)</p>
                        <p>• <strong>Threshold:</strong> > 0.30 untuk TKJ, ≤ 0.30 untuk TKR</p>
                        <p>• <strong>Jarak Positif (D+):</strong> Semakin kecil semakin baik</p>
                        <p>• <strong>Jarak Negatif (D-):</strong> Semakin besar semakin baik</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Auto calculate function
            document.getElementById('auto-calculate').addEventListener('click', function() {
                const dPositive = parseFloat(document.getElementById('jarak_positif').value);
                const dNegative = parseFloat(document.getElementById('jarak_negatif').value);

                if (dPositive && dNegative) {
                    const preference = dNegative / (dPositive + dNegative);
                    document.getElementById('nilai_preferensi').value = preference.toFixed(6);

                    // Auto select recommendation based on threshold
                    const recommendation = preference > 0.30 ? 'TKJ' : 'TKR';
                    document.getElementById('jurusan_rekomendasi').value = recommendation;

                    // Show success message
                    alert(
                        `Nilai preferensi berhasil dihitung: ${preference.toFixed(6)}\nRekomendasi: ${recommendation}`);
                } else {
                    alert('Harap isi nilai jarak positif dan negatif terlebih dahulu.');
                }
            });

            // Reset form function
            function resetForm() {
                if (confirm('Yakin ingin mengembalikan semua nilai ke nilai awal?')) {
                    // Reset to original values
                    document.getElementById('jarak_positif').value = '{{ $perhitungan->jarak_positif }}';
                    document.getElementById('jarak_negatif').value = '{{ $perhitungan->jarak_negatif }}';
                    document.getElementById('nilai_preferensi').value = '{{ $perhitungan->nilai_preferensi }}';
                    document.getElementById('jurusan_rekomendasi').value = '{{ $perhitungan->jurusan_rekomendasi }}';
                    document.getElementById('tahun_ajaran').value = '{{ $perhitungan->tahun_ajaran }}';
                }
            }

            // Form validation
            document.querySelector('form').addEventListener('submit', function(e) {
                const dPositive = parseFloat(document.getElementById('jarak_positif').value);
                const dNegative = parseFloat(document.getElementById('jarak_negatif').value);
                const preference = parseFloat(document.getElementById('nilai_preferensi').value);

                if (dPositive < 0 || dNegative < 0) {
                    e.preventDefault();
                    alert('Jarak tidak boleh bernilai negatif.');
                    return;
                }

                if (preference < 0 || preference > 1) {
                    e.preventDefault();
                    alert('Nilai preferensi harus berada antara 0 dan 1.');
                    return;
                }

                // Confirm submission
                const confirmed = confirm('Yakin ingin menyimpan perubahan perhitungan TOPSIS ini?');
                if (!confirmed) {
                    e.preventDefault();
                }
            });
        </script>
    @endpush

@endsection
