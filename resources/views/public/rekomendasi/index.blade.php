<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Rekomendasi Jurusan - SPK Pemilihan Jurusan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'navy': '#1e3a8a',
                        'navy-dark': '#1e40af',
                        'gold': '#fbbf24',
                    }
                }
            }
        }
    </script>
    <style>
        .fade-in {
            animation: fadeIn 0.6s ease-out forwards;
            opacity: 0;
            transform: translateY(10px);
        }

        .fade-in-delay-1 {
            animation-delay: 0.1s;
        }

        .fade-in-delay-2 {
            animation-delay: 0.2s;
        }

        .fade-in-delay-3 {
            animation-delay: 0.3s;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-gray-50 font-sans">
    <nav class="bg-white/80 backdrop-blur-lg shadow-sm border-b border-gray-200 sticky top-0 z-50">
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
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>
    </nav>

    <div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl w-full space-y-8">
            <div class="text-center fade-in">
                <div class="w-20 h-20 bg-navy rounded-2xl mx-auto mb-6 flex items-center justify-center shadow-lg">
                    <svg class="w-10 h-10 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Cek Hasil Rekomendasi Anda</h1>
                <p class="mt-2 text-lg text-gray-600">Masukkan NISN yang telah terdaftar untuk melihat hasil.</p>
            </div>

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg fade-in fade-in-delay-1"
                    role="alert">
                    <p class="font-bold">Gagal!</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-8 fade-in fade-in-delay-2">
                <form action="{{ route('rekomendasi.search') }}" method="GET">
                    <div class="mb-5">
                        <label for="nisn" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Induk Siswa Nasional (NISN)
                        </label>
                        <input type="text" id="nisn" name="nisn"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent text-lg tracking-wider"
                            placeholder="Ketik 10 digit NISN..." maxlength="10" pattern="[0-9]{10}"
                            value="{{ old('nisn') }}" required>
                        @error('nisn')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-navy text-white py-3 px-4 rounded-lg hover:bg-navy-dark transition duration-300 font-bold text-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        Cari Rekomendasi
                    </button>
                </form>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-4 fade-in fade-in-delay-3">
                <div class="bg-white rounded-lg p-4 text-center border border-gray-200">
                    <div class="text-2xl font-bold text-navy">{{ $statistics['total_perhitungan'] }}</div>
                    <div class="text-xs text-gray-600 mt-1">Total Perhitungan</div>
                </div>
                <div class="bg-white rounded-lg p-4 text-center border border-gray-200">
                    <div class="text-2xl font-bold text-blue-600">{{ $statistics['tkj_count'] }}</div>
                    <div class="text-xs text-gray-600 mt-1">Rekomendasi TKJ</div>
                </div>
                <div class="bg-white rounded-lg p-4 text-center border border-gray-200">
                    <div class="text-2xl font-bold text-green-600">{{ $statistics['tkr_count'] }}</div>
                    <div class="text-xs text-gray-600 mt-1">Rekomendasi TKR</div>
                </div>
                <div class="bg-white rounded-lg p-4 text-center border border-gray-200">
                    <div class="text-2xl font-bold text-gray-700">{{ $statistics['total_siswa'] }}</div>
                    <div class="text-xs text-gray-600 mt-1">Total Siswa</div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white border-t border-gray-200 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-600">
            <p>&copy; {{ date('Y') }} SMK Penida 2 Katapang. All rights reserved.</p>
        </div>
    </footer>

    <script>
        document.getElementById('nisn').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>

</html>
