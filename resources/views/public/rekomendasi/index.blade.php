<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Rekomendasi Jurusan - SPK Pemilihan Jurusan</title>
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
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-navy rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">SP</span>
                    </div>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">SPK Pemilihan Jurusan</h1>
                        <p class="text-xs text-gray-500">SMK Penida 2 Katapang</p>
                    </div>
                </div>
                <a href="{{ route('welcome') }}" class="text-navy hover:text-navy-dark text-sm font-medium">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-navy rounded-2xl mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-10 h-10 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Cek Rekomendasi Jurusan</h1>
                <p class="text-gray-600">Masukkan NISN Anda untuk melihat hasil rekomendasi jurusan berdasarkan metode
                    TOPSIS</p>
            </div>

            <!-- Alert Messages -->
            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Search Form -->
            <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
                <form action="{{ route('rekomendasi.search') }}" method="GET">
                    <div class="mb-6">
                        <label for="nisn" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Induk Siswa Nasional (NISN)
                        </label>
                        <input type="text" id="nisn" name="nisn"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent text-lg"
                            placeholder="Contoh: 0066731537" maxlength="10" pattern="[0-9]{10}"
                            value="{{ old('nisn') }}" required>
                        @error('nisn')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            NISN terdiri dari 10 digit angka
                        </p>
                    </div>

                    <button type="submit"
                        class="w-full bg-navy text-white py-3 px-4 rounded-lg hover:bg-navy-dark transition duration-200 font-medium text-lg">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Cari Rekomendasi
                    </button>
                </form>
            </div>

            <!-- Statistics -->
            <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-lg p-4 text-center border border-gray-200">
                    <div class="text-2xl font-bold text-navy">{{ $statistics['total_siswa'] }}</div>
                    <div class="text-xs text-gray-600 mt-1">Total Siswa</div>
                </div>
                <div class="bg-white rounded-lg p-4 text-center border border-gray-200">
                    <div class="text-2xl font-bold text-navy">{{ $statistics['total_perhitungan'] }}</div>
                    <div class="text-xs text-gray-600 mt-1">Perhitungan</div>
                </div>
                <div class="bg-white rounded-lg p-4 text-center border border-gray-200">
                    <div class="text-2xl font-bold text-blue-600">{{ $statistics['tkj_count'] }}</div>
                    <div class="text-xs text-gray-600 mt-1">Rekomendasi TKJ</div>
                </div>
                <div class="bg-white rounded-lg p-4 text-center border border-gray-200">
                    <div class="text-2xl font-bold text-green-600">{{ $statistics['tkr_count'] }}</div>
                    <div class="text-xs text-gray-600 mt-1">Rekomendasi TKR</div>
                </div>
            </div>

            <!-- Info -->
            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h4 class="font-medium text-blue-800 mb-2">Informasi Penting</h4>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• Hasil rekomendasi menggunakan metode TOPSIS dengan 12 kriteria penilaian</li>
                            <li>• Rekomendasi didasarkan pada nilai akademik, minat, keahlian, dan latar belakang</li>
                            <li>• Hasil rekomendasi bersifat informatif untuk membantu pengambilan keputusan</li>
                            <li>• Jika NISN tidak ditemukan, hubungi admin sekolah</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-sm text-gray-600">
                <p>&copy; 2024 SMK Penida 2 Katapang. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Auto format NISN input (only numbers)
        document.getElementById('nisn').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>

</html>
