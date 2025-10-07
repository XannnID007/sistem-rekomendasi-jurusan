{{-- resources/views/public/submission/form.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Rekomendasi Jurusan - SPK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'navy': '#1e3a8a',
                        'navy-dark': '#1e40af',
                        'gold': '#fbbf24',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50">

    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-navy rounded-lg flex items-center justify-center">
                        <span class="text-white font-semibold text-lg">SP</span>
                    </div>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">SPK Pemilihan Jurusan</h1>
                        <p class="text-xs text-gray-500">SMK Penida 2 Katapang</p>
                    </div>
                </div>
                <a href="{{ route('welcome') }}" class="text-navy hover:text-navy-dark text-sm font-medium">
                    ← Kembali
                </a>
            </div>
        </div>
    </nav>

    <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">

            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-navy rounded-2xl mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Form Rekomendasi Jurusan</h1>
                <p class="text-gray-600">Isi data diri dan kriteria untuk mendapatkan rekomendasi jurusan</p>
            </div>

            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h3 class="text-red-800 font-semibold mb-2">Terdapat kesalahan:</h3>
                            <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('submission.submit') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Section 1: Data Pribadi -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                            <span class="text-blue-600 font-bold text-lg">1</span>
                        </div>
                        <h3 class="text-xl font-bold text-navy">Data Pribadi</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">NISN <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nisn" maxlength="10" value="{{ old('nisn') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy @error('nisn') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-gray-500">10 digit angka</p>
                            @error('nisn')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy @error('nama_lengkap') border-red-500 @enderror">
                            @error('nama_lengkap')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin <span
                                    class="text-red-500">*</span></label>
                            <select name="jenis_kelamin" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy @error('jenis_kelamin') border-red-500 @enderror">
                                <option value="">Pilih</option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                            @error('jenis_kelamin')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy @error('tanggal_lahir') border-red-500 @enderror">
                            @error('tanggal_lahir')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email <span
                                    class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon <span
                                    class="text-red-500">*</span></label>
                            <input type="tel" name="no_telepon" value="{{ old('no_telepon') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy @error('no_telepon') border-red-500 @enderror">
                            @error('no_telepon')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat <span
                                    class="text-red-500">*</span></label>
                            <textarea name="alamat" rows="3" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy @error('alamat') border-red-500 @enderror">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Orang Tua <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama_orang_tua" value="{{ old('nama_orang_tua') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy @error('nama_orang_tua') border-red-500 @enderror">
                            @error('nama_orang_tua')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon Orang Tua <span
                                    class="text-red-500">*</span></label>
                            <input type="tel" name="no_telepon_orang_tua"
                                value="{{ old('no_telepon_orang_tua') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy @error('no_telepon_orang_tua') border-red-500 @enderror">
                            @error('no_telepon_orang_tua')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Ajaran <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran', '2024/2025') }}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy @error('tahun_ajaran') border-red-500 @enderror">
                            @error('tahun_ajaran')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Nilai Akademik -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                            <span class="text-green-600 font-bold text-lg">2</span>
                        </div>
                        <h3 class="text-xl font-bold text-navy">Nilai Akademik</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ([
        'nilai_ipa' => 'Nilai IPA',
        'nilai_ips' => 'Nilai IPS',
        'nilai_matematika' => 'Nilai Matematika',
        'nilai_bahasa_indonesia' => 'Nilai Bahasa Indonesia',
        'nilai_bahasa_inggris' => 'Nilai Bahasa Inggris',
        'nilai_pkn' => 'Nilai PKN',
    ] as $field => $label)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ $label }} <span
                                        class="text-red-500">*</span></label>
                                <input type="number" name="{{ $field }}" min="0" max="100"
                                    step="0.01" value="{{ old($field) }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy @error($field) border-red-500 @enderror">
                                <p class="mt-1 text-xs text-gray-500">Skala 0-100</p>
                                @error($field)
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Section 3: Minat & Bakat -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                            <span class="text-purple-600 font-bold text-lg">3</span>
                        </div>
                        <h3 class="text-xl font-bold text-navy">Minat & Bakat</h3>
                    </div>

                    <div class="space-y-6">
                        @php
                            $minatOptions = [
                                'minat_a' => [
                                    'label' => 'Minat Bidang Kreatif',
                                    'options' => [
                                        'Musik & Teater',
                                        'Fotografi & Videografi',
                                        'Seni & Kerajinan',
                                        'Desain Grafis',
                                    ],
                                ],
                                'minat_b' => [
                                    'label' => 'Minat Bidang Teknologi (Paling Penting)',
                                    'options' => [
                                        'Teknologi informasi & Komunikasi',
                                        'Komputer',
                                        'Elektronik',
                                        'Mesin',
                                    ],
                                ],
                                'minat_c' => [
                                    'label' => 'Minat Bidang Ilmiah',
                                    'options' => ['Kimia', 'Biologi & Lingkungan', 'Fisika'],
                                ],
                                'minat_d' => [
                                    'label' => 'Minat Bidang Bisnis',
                                    'options' => ['Bisnis & Enterpreneurship', 'Pemasaran'],
                                ],
                            ];
                        @endphp

                        @foreach ($minatOptions as $field => $data)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $data['label'] }} <span class="text-red-500">*</span>
                                </label>
                                <select name="{{ $field }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy @error($field) border-red-500 @enderror">
                                    <option value="">Pilih minat</option>
                                    @foreach ($data['options'] as $option)
                                        <option value="{{ $option }}"
                                            {{ old($field) == $option ? 'selected' : '' }}>
                                            {{ $option }}
                                        </option>
                                    @endforeach
                                </select>
                                @error($field)
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Keahlian Khusus <span
                                    class="text-red-500">*</span></label>
                            <select name="keahlian" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy @error('keahlian') border-red-500 @enderror">
                                <option value="">Pilih keahlian</option>
                                @foreach (['perangkat lunak', 'menganalisa', 'kelistrikan', 'Mengembangkan Rencana & Strategi', 'memecahkan masalah', 'Menggunakan Perangkat Lunak & Komputer'] as $option)
                                    <option value="{{ $option }}"
                                        {{ old('keahlian') == $option ? 'selected' : '' }}>
                                        {{ ucfirst($option) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('keahlian')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 4: Biaya Pergelombang -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                            <span class="text-amber-600 font-bold text-lg">4</span>
                        </div>
                        <h3 class="text-xl font-bold text-navy">Biaya Pendaftaran</h3>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilihan Biaya Pergelombang <span
                                class="text-red-500">*</span></label>
                        <select name="biaya_gelombang" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy @error('biaya_gelombang') border-red-500 @enderror">
                            <option value="">Pilih gelombang pendaftaran</option>
                            <option value="G1. Rp 1.000.000"
                                {{ old('biaya_gelombang') == 'G1. Rp 1.000.000' ? 'selected' : '' }}>
                                Gelombang 1 - Rp 1.000.000 (Paling Murah)
                            </option>
                            <option value="G2. Rp 1.500.000"
                                {{ old('biaya_gelombang') == 'G2. Rp 1.500.000' ? 'selected' : '' }}>
                                Gelombang 2 - Rp 1.500.000 (Menengah)
                            </option>
                            <option value="G3. Rp 2.000.000"
                                {{ old('biaya_gelombang') == 'G3. Rp 2.000.000' ? 'selected' : '' }}>
                                Gelombang 3 - Rp 2.000.000 (Terakhir)
                            </option>
                        </select>
                        <p class="mt-2 text-xs text-gray-500">
                            💡 Info: Gelombang 1 adalah yang termurah. Semakin cepat mendaftar, semakin hemat biaya!
                        </p>
                        @error('biaya_gelombang')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('welcome') }}"
                        class="px-6 py-3 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition duration-200">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-8 py-3 bg-navy text-white font-medium rounded-lg hover:bg-navy-dark transition duration-200 shadow-lg hover:shadow-xl">
                        Submit & Dapatkan Rekomendasi
                    </button>
                </div>

            </form>

        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <p class="text-center text-gray-600 text-sm">
                &copy; 2024 SMK Penida 2 Katapang. Sistem Pendukung Keputusan Pemilihan Jurusan.
            </p>
        </div>
    </footer>

    <script>
        // Auto format NISN - only numbers
        document.querySelector('input[name="nisn"]').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Auto format phone numbers - only numbers
        document.querySelectorAll('input[type="tel"]').forEach(function(input) {
            input.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        });
    </script>

</body>

</html>
