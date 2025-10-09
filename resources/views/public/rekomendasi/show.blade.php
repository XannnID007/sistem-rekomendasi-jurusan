<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Rekomendasi - {{ $pesertaDidik->nama_lengkap }}</title>
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

        .fade-in-delay-4 {
            animation-delay: 0.4s;
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
                    <div class="w-10 h-10 bg-navy rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">SPK</span>
                    </div>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">Hasil Rekomendasi Jurusan</h1>
                        <p class="text-xs text-gray-500">{{ $pesertaDidik->nama_lengkap }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('rekomendasi.index') }}"
                        class="text-navy hover:text-navy-dark text-sm font-medium">
                        ← Cari Lagi
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            @if ($hasCalculation)
                <div class="space-y-8">
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden fade-in">
                        <div class="p-8">
                            <p class="text-base text-gray-500">Hasil Rekomendasi untuk:</p>
                            <h1 class="text-3xl font-extrabold text-navy tracking-tight">
                                {{ $pesertaDidik->nama_lengkap }}</h1>
                            <p class="text-gray-600 mt-1">NISN: {{ $pesertaDidik->nisn }}</p>
                        </div>
                        <div
                            class="bg-gradient-to-r from-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-500 to-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-600 p-8">
                            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                                <div class="flex items-center space-x-5">
                                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                                        @if ($perhitungan->jurusan_rekomendasi === 'TKJ')
                                            <svg class="w-9 h-9 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                                            </svg>
                                        @else
                                            <svg class="w-9 h-9 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-base text-white/80">Rekomendasi Jurusan</p>
                                        <p class="text-3xl font-extrabold text-white">
                                            {{ $perhitungan->rekomendasi_lengkap }}</p>
                                    </div>
                                </div>
                                <div class="text-center md:text-right">
                                    <p class="text-base text-white/80">Nilai Preferensi</p>
                                    <p class="text-5xl font-extrabold text-white tracking-tight">
                                        {{ number_format($perhitungan->nilai_preferensi, 4) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 fade-in fade-in-delay-1">
                        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 text-center">
                            <p class="text-sm font-medium text-gray-600">Peringkat di Angkatan</p>
                            <p class="text-4xl font-bold text-navy mt-2">{{ $ranking }}<span
                                    class="text-2xl text-gray-400 font-medium">/{{ $totalStudents }}</span></p>
                        </div>
                        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 text-center">
                            <p class="text-sm font-medium text-gray-600">Persentil</p>
                            <p class="text-4xl font-bold text-navy mt-2">Top {{ $percentile }}%</p>
                        </div>
                        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 text-center">
                            <p class="text-sm font-medium text-gray-600">Perbandingan Rata-rata</p>
                            <p
                                class="text-2xl font-bold mt-2 {{ $perhitungan->nilai_preferensi > $avgPreference ? 'text-green-600' : 'text-orange-600' }}">
                                {{ $perhitungan->nilai_preferensi > $avgPreference ? 'Di Atas' : 'Di Bawah' }}
                            </p>
                            <p class="text-xs text-gray-500">(Rata-rata: {{ number_format($avgPreference, 4) }})</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 fade-in fade-in-delay-2">
                        <h3 class="text-xl font-bold text-navy mb-4">Penjelasan Rekomendasi</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $explanation['reason'] }}</p>
                        <p class="text-gray-600 leading-relaxed mt-2">{{ $explanation['description'] }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 fade-in fade-in-delay-4">
                        <a href="{{ route('rekomendasi.detail', $pesertaDidik->nisn) }}"
                            class="bg-navy text-white px-6 py-4 rounded-xl hover:bg-navy-dark transition text-center font-bold text-lg flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <span>🔬</span>
                            <span>Lihat Analisis Lengkap</span>
                        </a>
                        <a href="{{ route('rekomendasi.analisis', $pesertaDidik->nisn) }}"
                            class="bg-white border-2 border-navy text-navy px-6 py-4 rounded-xl hover:bg-navy hover:text-white transition text-center font-bold text-lg flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <span>📊</span>
                            <span>Detail Perhitungan</span>
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-12 text-center fade-in">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Belum Ada Rekomendasi</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        Rekomendasi untuk <strong>{{ $pesertaDidik->nama_lengkap }}</strong> belum tersedia. Data perlu
                        dihitung terlebih dahulu oleh admin.
                    </p>
                </div>
            @endif
        </div>
    </div>

    <footer class="bg-white border-t border-gray-200 py-6 mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-600">
            <p>&copy; {{ date('Y') }} SMK Penida 2 Katapang. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
