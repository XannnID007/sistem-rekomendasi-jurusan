@extends('layouts.admin')

@section('title', 'Edit Penilaian')
@section('page-title', 'Edit Data Penilaian')
@section('page-description', 'Untuk: ' . $pesertaDidik->nama_lengkap . ' (' . $pesertaDidik->nisn . ')')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-navy to-navy-dark">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gold rounded-full flex items-center justify-center">
                        <span class="text-navy font-bold">{{ substr($pesertaDidik->nama_lengkap, 0, 1) }}</span>
                    </div>
                    <div class="text-white">
                        <h3 class="text-lg font-semibold">Edit Penilaian</h3>
                        <p class="text-blue-100 text-sm">{{ $pesertaDidik->nama_lengkap }} - NISN: {{ $pesertaDidik->nisn }}
                        </p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.peserta-didik.penilaian.update', [$pesertaDidik, $penilaian]) }}"
                class="p-6">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-navy mb-4">Informasi Dasar</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700 mb-2">
                                Tahun Ajaran <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="tahun_ajaran" name="tahun_ajaran"
                                value="{{ old('tahun_ajaran', $penilaian->tahun_ajaran) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('tahun_ajaran') border-red-500 @enderror"
                                required>
                            @error('tahun_ajaran')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Academic Scores -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-navy mb-4">Nilai Akademik</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="nilai_ipa" class="block text-sm font-medium text-gray-700 mb-2">
                                Nilai IPA <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="nilai_ipa" name="nilai_ipa"
                                value="{{ old('nilai_ipa', $penilaian->nilai_ipa) }}" min="0" max="100"
                                step="0.1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('nilai_ipa') border-red-500 @enderror"
                                placeholder="0-100" required>
                            @error('nilai_ipa')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nilai_ips" class="block text-sm font-medium text-gray-700 mb-2">
                                Nilai IPS <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="nilai_ips" name="nilai_ips"
                                value="{{ old('nilai_ips', $penilaian->nilai_ips) }}" min="0" max="100"
                                step="0.1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('nilai_ips') border-red-500 @enderror"
                                placeholder="0-100" required>
                            @error('nilai_ips')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nilai_matematika" class="block text-sm font-medium text-gray-700 mb-2">
                                Nilai Matematika <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="nilai_matematika" name="nilai_matematika"
                                value="{{ old('nilai_matematika', $penilaian->nilai_matematika) }}" min="0"
                                max="100" step="0.1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('nilai_matematika') border-red-500 @enderror"
                                placeholder="0-100" required>
                            @error('nilai_matematika')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nilai_bahasa_indonesia" class="block text-sm font-medium text-gray-700 mb-2">
                                Nilai Bahasa Indonesia <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="nilai_bahasa_indonesia" name="nilai_bahasa_indonesia"
                                value="{{ old('nilai_bahasa_indonesia', $penilaian->nilai_bahasa_indonesia) }}"
                                min="0" max="100" step="0.1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('nilai_bahasa_indonesia') border-red-500 @enderror"
                                placeholder="0-100" required>
                            @error('nilai_bahasa_indonesia')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nilai_bahasa_inggris" class="block text-sm font-medium text-gray-700 mb-2">
                                Nilai Bahasa Inggris <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="nilai_bahasa_inggris" name="nilai_bahasa_inggris"
                                value="{{ old('nilai_bahasa_inggris', $penilaian->nilai_bahasa_inggris) }}" min="0"
                                max="100" step="0.1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('nilai_bahasa_inggris') border-red-500 @enderror"
                                placeholder="0-100" required>
                            @error('nilai_bahasa_inggris')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nilai_pkn" class="block text-sm font-medium text-gray-700 mb-2">
                                Nilai pkn <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="nilai_pkn" name="nilai_pkn"
                                value="{{ old('nilai_pkn', $penilaian->nilai_pkn) }}" min="0" max="100"
                                step="0.1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('nilai_pkn') border-red-500 @enderror"
                                placeholder="0-100" required>
                            @error('nilai_pkn')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Interests -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-navy mb-4">Data Minat</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="minat_a" class="block text-sm font-medium text-gray-700 mb-2">
                                Minat A <span class="text-red-500">*</span>
                            </label>
                            <select name="minat_a" id="minat_a"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('minat_a') border-red-500 @enderror"
                                required>
                                <option value="">Pilih Minat A</option>
                                <option value="Musik & Teater"
                                    {{ old('minat_a', $penilaian->minat_a) === 'Musik & Teater' ? 'selected' : '' }}>Musik
                                    & Teater</option>
                                <option value="Fotografi & Videografi"
                                    {{ old('minat_a', $penilaian->minat_a) === 'Fotografi & Videografi' ? 'selected' : '' }}>
                                    Fotografi & Videografi</option>
                                <option value="Seni & Kerajinan"
                                    {{ old('minat_a', $penilaian->minat_a) === 'Seni & Kerajinan' ? 'selected' : '' }}>Seni
                                    & Kerajinan</option>
                                <option value="Desain Grafis"
                                    {{ old('minat_a', $penilaian->minat_a) === 'Desain Grafis' ? 'selected' : '' }}>
                                    Desain Grafis</option>
                            </select>
                            @error('minat_a')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="minat_b" class="block text-sm font-medium text-gray-700 mb-2">
                                Minat B <span class="text-red-500">*</span>
                            </label>
                            <select name="minat_b" id="minat_b"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('minat_b') border-red-500 @enderror"
                                required>
                                <option value="">Pilih Minat B</option>
                                <option value="Teknologi informasi & Komunikasi"
                                    {{ old('minat_b', $penilaian->minat_b) === 'Teknologi informasi & Komunikasi' ? 'selected' : '' }}>
                                    Teknologi informasi & Komunikasi</option>
                                <option value="Komputer"
                                    {{ old('minat_b', $penilaian->minat_b) === 'Komputer' ? 'selected' : '' }}>Komputer
                                </option>
                                <option value="Elektronik"
                                    {{ old('minat_b', $penilaian->minat_b) === 'Elektronik' ? 'selected' : '' }}>Elektronik
                                </option>
                                <option value="Mesin"
                                    {{ old('minat_b', $penilaian->minat_b) === 'Mesin' ? 'selected' : '' }}>Mesin</option>
                            </select>
                            @error('minat_b')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="minat_c" class="block text-sm font-medium text-gray-700 mb-2">
                                Minat C <span class="text-red-500">*</span>
                            </label>
                            <select name="minat_c" id="minat_c"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('minat_c') border-red-500 @enderror"
                                required>
                                <option value="">Pilih Minat C</option>
                                <option value="Kimia"
                                    {{ old('minat_c', $penilaian->minat_c) === 'Kimia' ? 'selected' : '' }}>Kimia</option>
                                <option value="Biologi & Lingkungan"
                                    {{ old('minat_c', $penilaian->minat_c) === 'Biologi & Lingkungan' ? 'selected' : '' }}>
                                    Biologi & Lingkungan</option>
                                <option value="Fisika"
                                    {{ old('minat_c', $penilaian->minat_c) === 'Fisika' ? 'selected' : '' }}>Fisika
                                </option>
                            </select>
                            @error('minat_c')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="minat_d" class="block text-sm font-medium text-gray-700 mb-2">
                                Minat D <span class="text-red-500">*</span>
                            </label>
                            <select name="minat_d" id="minat_d"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('minat_d') border-red-500 @enderror"
                                required>
                                <option value="">Pilih Minat D</option>
                                <option value="Bisnis & Enterpreneurship"
                                    {{ old('minat_d', $penilaian->minat_d) === 'Bisnis & Enterpreneurship' ? 'selected' : '' }}>
                                    Bisnis & Enterpreneurship</option>
                                <option value="Pemasaran"
                                    {{ old('minat_d', $penilaian->minat_d) === 'Pemasaran' ? 'selected' : '' }}>Pemasaran
                                </option>
                            </select>
                            @error('minat_d')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Skills and Background -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-navy mb-4">Keahlian & Latar Belakang</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="keahlian" class="block text-sm font-medium text-gray-700 mb-2">
                                Bidang Keahlian <span class="text-red-500">*</span>
                            </label>
                            <select name="keahlian" id="keahlian"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('keahlian') border-red-500 @enderror"
                                required>
                                <option value="">Pilih Bidang Keahlian</option>
                                <option value="perangkat lunak"
                                    {{ old('keahlian', $penilaian->keahlian) === 'perangkat lunak' ? 'selected' : '' }}>
                                    Perangkat Lunak</option>
                                <option value="menganalisa"
                                    {{ old('keahlian', $penilaian->keahlian) === 'menganalisa' ? 'selected' : '' }}>
                                    Menganalisa</option>
                                <option value="kelistrikan"
                                    {{ old('keahlian', $penilaian->keahlian) === 'kelistrikan' ? 'selected' : '' }}>
                                    Kelistrikan</option>
                                <option value="Mengembangkan Rencana & Strategi"
                                    {{ old('keahlian', $penilaian->keahlian) === 'Mengembangkan Rencana & Strategi' ? 'selected' : '' }}>
                                    Mengembangkan Rencana & Strategi</option>
                                <option value="Menggunakan Perangkat Lunak & Komputer"
                                    {{ old('keahlian', $penilaian->keahlian) === 'Menggunakan Perangkat Lunak & Komputer' ? 'selected' : '' }}>
                                    Menggunakan Perangkat Lunak & Komputer</option>
                                <option value="memecahkan masalah"
                                    {{ old('keahlian', $penilaian->keahlian) === 'memecahkan masalah' ? 'selected' : '' }}>
                                    Memecahkan Masalah</option>
                            </select>
                            @error('keahlian')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="penghasilan_ortu" class="block text-sm font-medium text-gray-700 mb-2">
                                Penghasilan Orang Tua <span class="text-red-500">*</span>
                            </label>
                            <select name="penghasilan_ortu" id="penghasilan_ortu"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('penghasilan_ortu') border-red-500 @enderror"
                                required>
                                <option value="">Pilih Tingkat Penghasilan</option>
                                <option value="G1. 1.000.000"
                                    {{ old('penghasilan_ortu', $penilaian->penghasilan_ortu) === 'G1. 1.000.000' ? 'selected' : '' }}>
                                    G1. Rp 1.000.000 (Rendah)</option>
                                <option value="G2. 1.500.000"
                                    {{ old('penghasilan_ortu', $penilaian->penghasilan_ortu) === 'G2. 1.500.000' ? 'selected' : '' }}>
                                    G2. Rp 1.500.000 (Sedang)</option>
                                <option value="G3. 2.000.000"
                                    {{ old('penghasilan_ortu', $penilaian->penghasilan_ortu) === 'G3. 2.000.000' ? 'selected' : '' }}>
                                    G3. Rp 2.000.000 (Tinggi)</option>
                            </select>
                            @error('penghasilan_ortu')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.peserta-didik.show', $pesertaDidik) }}"
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
            // Calculate average automatically
            function calculateAverage() {
                const values = [
                    parseFloat(document.getElementById('nilai_ipa').value) || 0,
                    parseFloat(document.getElementById('nilai_ips').value) || 0,
                    parseFloat(document.getElementById('nilai_matematika').value) || 0,
                    parseFloat(document.getElementById('nilai_bahasa_indonesia').value) || 0,
                    parseFloat(document.getElementById('nilai_bahasa_inggris').value) || 0,
                    parseFloat(document.getElementById('nilai_pkn').value) || 0
                ];

                const validValues = values.filter(v => v > 0);
                if (validValues.length > 0) {
                    const average = validValues.reduce((a, b) => a + b, 0) / validValues.length;
                    console.log('Rata-rata nilai:', average.toFixed(2));
                }
            }

            // Add event listeners to academic score inputs
            document.querySelectorAll('input[name^="nilai_"]').forEach(input => {
                input.addEventListener('input', calculateAverage);
            });
        </script>
    @endpush

@endsection
