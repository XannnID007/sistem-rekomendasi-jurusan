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
                    <img src="/images/logo.png" alt="Logo SPK" class="w-10 h-10 object-contain"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="w-10 h-10 bg-navy rounded-lg flex items-center justify-center" style="display: none;">
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
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy">
                            <p class="mt-1 text-xs text-gray-500">10 digit angka</p>
                            @error('nisn')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy">
                            @error('nama_lengkap')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin <span
                                    class="text-red-500">*</span></label>
                            <select name="jenis_kelamin" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy">
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
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy">
                            @error('tanggal_lahir')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email <span
                                    class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon <span
                                    class="text-red-500">*</span></label>
                            <input type="tel" name="no_telepon" value="{{ old('no_telepon') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy">
                            @error('no_telepon')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat <span
                                    class="text-red-500">*</span></label>
                            <textarea name="alamat" rows="3" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Orang Tua <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama_orang_tua" value="{{ old('nama_orang_tua') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy">
                            @error('nama_orang_tua')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon Orang Tua <span
                                    class="text-red-500">*</span></label>
                            <input type="tel" name="no_telepon_orang_tua"
                                value="{{ old('no_telepon_orang_tua') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy">
                            @error('no_telepon_orang_tua')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Ajaran <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran', '2024/2025') }}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy">
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
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nilai IPA <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="nilai_ipa" min="0" max="100" step="0.01"
                                value="{{ old('nilai_ipa') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">Skala 0-100</p>
                            @error('nilai_ipa')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nilai IPS <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="nilai_ips" min="0" max="100" step="0.01"
                                value="{{ old('nilai_ips') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">Skala 0-100</p>
                            @error('nilai_ips')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nilai Matematika <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="nilai_matematika" min="0" max="100"
                                step="0.01" value="{{ old('nilai_matematika') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">Skala 0-100</p>
                            @error('nilai_matematika')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nilai Bahasa Indonesia <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="nilai_bahasa_indonesia" min="0" max="100"
                                step="0.01" value="{{ old('nilai_bahasa_indonesia') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">Skala 0-100</p>
                            @error('nilai_bahasa_indonesia')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nilai Bahasa Inggris <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="nilai_bahasa_inggris" min="0" max="100"
                                step="0.01" value="{{ old('nilai_bahasa_inggris') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">Skala 0-100</p>
                            @error('nilai_bahasa_inggris')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nilai PKN <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="nilai_pkn" min="0" max="100" step="0.01"
                                value="{{ old('nilai_pkn') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">Skala 0-100</p>
                            @error('nilai_pkn')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
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
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Minat Bidang Teknologi
                                <span class="text-red-500">*</span></label>
                            <select name="minat_a" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy focus:border-transparent">
                                <option value="">Pilih tingkat minat</option>
                                <option value="Sangat Tinggi"
                                    {{ old('minat_a') == 'Sangat Tinggi' ? 'selected' : '' }}>
                                    Sangat Tinggi</option>
                                <option value="Tinggi" {{ old('minat_a') == 'Tinggi' ? 'selected' : '' }}>Tinggi
                                </option>
                                <option value="Sedang" {{ old('minat_a') == 'Sedang' ? 'selected' : '' }}>Sedang
                                </option>
                                <option value="Rendah" {{ old('minat_a') == 'Rendah' ? 'selected' : '' }}>Rendah
                                </option>
                                <option value="Sangat Rendah"
                                    {{ old('minat_a') == 'Sangat Rendah' ? 'selected' : '' }}>
                                    Sangat Rendah</option>
                            </select>
                            @error('minat_a')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Minat Bidang Otomotif <span
                                    class="text-red-500">*</span></label>
                            <select name="minat_b" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy focus:border-transparent">
                                <option value="">Pilih tingkat minat</option>
                                <option value="Sangat Tinggi"
                                    {{ old('minat_b') == 'Sangat Tinggi' ? 'selected' : '' }}>
                                    Sangat Tinggi</option>
                                <option value="Tinggi" {{ old('minat_b') == 'Tinggi' ? 'selected' : '' }}>Tinggi
                                </option>
                                <option value="Sedang" {{ old('minat_b') == 'Sedang' ? 'selected' : '' }}>Sedang
                                </option>
                                <option value="Rendah" {{ old('minat_b') == 'Rendah' ? 'selected' : '' }}>Rendah
                                </option>
                                <option value="Sangat Rendah"
                                    {{ old('minat_b') == 'Sangat Rendah' ? 'selected' : '' }}>
                                    Sangat Rendah</option>
                            </select>
                            @error('minat_b')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Minat Bekerja dengan
                                Komputer <span class="text-red-500">*</span></label>
                            <select name="minat_c" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy focus:border-transparent">
                                <option value="">Pilih tingkat minat</option>
                                <option value="Sangat Tinggi"
                                    {{ old('minat_c') == 'Sangat Tinggi' ? 'selected' : '' }}>
                                    Sangat Tinggi</option>
                                <option value="Tinggi" {{ old('minat_c') == 'Tinggi' ? 'selected' : '' }}>Tinggi
                                </option>
                                <option value="Sedang" {{ old('minat_c') == 'Sedang' ? 'selected' : '' }}>Sedang
                                </option>
                                <option value="Rendah" {{ old('minat_c') == 'Rendah' ? 'selected' : '' }}>Rendah
                                </option>
                                <option value="Sangat Rendah"
                                    {{ old('minat_c') == 'Sangat Rendah' ? 'selected' : '' }}>
                                    Sangat Rendah</option>
                            </select>
                            @error('minat_c')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Minat Bekerja dengan Mesin
                                <span class="text-red-500">*</span></label>
                            <select name="minat_d" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy focus:border-transparent">
                                <option value="">Pilih tingkat minat</option>
                                <option value="Sangat Tinggi"
                                    {{ old('minat_d') == 'Sangat Tinggi' ? 'selected' : '' }}>
                                    Sangat Tinggi</option>
                                <option value="Tinggi" {{ old('minat_d') == 'Tinggi' ? 'selected' : '' }}>Tinggi
                                </option>
                                <option value="Sedang" {{ old('minat_d') == 'Sedang' ? 'selected' : '' }}>Sedang
                                </option>
                                <option value="Rendah" {{ old('minat_d') == 'Rendah' ? 'selected' : '' }}>Rendah
                                </option>
                                <option value="Sangat Rendah"
                                    {{ old('minat_d') == 'Sangat Rendah' ? 'selected' : '' }}>
                                    Sangat Rendah</option>
                            </select>
                            @error('minat_d')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Keahlian Khusus <span
                                    class="text-red-500">*</span></label>
                            <select name="keahlian" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy focus:border-transparent">
                                <option value="">Pilih keahlian</option>
                                <option value="Programming" {{ old('keahlian') == 'Programming' ? 'selected' : '' }}>
                                    Programming</option>
                                <option value="Networking" {{ old('keahlian') == 'Networking' ? 'selected' : '' }}>
                                    Networking</option>
                                <option value="Hardware" {{ old('keahlian') == 'Hardware' ? 'selected' : '' }}>
                                    Hardware
                                </option>
                                <option value="Mekanik" {{ old('keahlian') == 'Mekanik' ? 'selected' : '' }}>Mekanik
                                </option>
                                <option value="Elektronik" {{ old('keahlian') == 'Elektronik' ? 'selected' : '' }}>
                                    Elektronik</option>
                                <option value="Otomotif" {{ old('keahlian') == 'Otomotif' ? 'selected' : '' }}>
                                    Otomotif
                                </option>
                                <option value="Lainnya" {{ old('keahlian') == 'Lainnya' ? 'selected' : '' }}>Lainnya
                                </option>
                            </select>
                            @error('keahlian')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 4: Data Ekonomi -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                            <span class="text-amber-600 font-bold text-lg">4</span>
                        </div>
                        <h3 class="text-xl font-bold text-navy">Data Ekonomi Keluarga</h3>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Penghasilan Orang Tua per Bulan
                            <span class="text-red-500">*</span></label>
                        <select name="penghasilan_ortu" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy focus:border-transparent">
                            <option value="">Pilih rentang penghasilan</option>
                            <option value="< 1 Juta" {{ old('penghasilan_ortu') == '< 1 Juta' ? 'selected' : '' }}>
                                &lt; Rp 1.000.000</option>
                            <option value="1-3 Juta" {{ old('penghasilan_ortu') == '1-3 Juta' ? 'selected' : '' }}>Rp
                                1.000.000 - Rp 3.000.000</option>
                            <option value="3-5 Juta" {{ old('penghasilan_ortu') == '3-5 Juta' ? 'selected' : '' }}>Rp
                                3.000.000 - Rp 5.000.000</option>
                            <option value="> 5 Juta" {{ old('penghasilan_ortu') == '> 5 Juta' ? 'selected' : '' }}>
                                &gt; Rp 5.000.000</option>
                        </select>
                        @error('penghasilan_ortu')
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

</body>

</html>
