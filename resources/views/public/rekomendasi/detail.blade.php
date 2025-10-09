<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisis Lengkap - {{ $pesertaDidik->nama_lengkap }}</title>
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
            from {
                opacity: 0;
                transform: translateY(15px);
            }

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
                        <h1 class="text-lg font-semibold text-gray-900">Analisis Mendalam</h1>
                        <p class="text-xs text-gray-500">{{ $pesertaDidik->nama_lengkap }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('rekomendasi.show', $pesertaDidik->nisn) }}"
                        class="text-navy hover:text-navy-dark text-sm font-medium">
                        ← Ringkasan Hasil
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto space-y-8">

            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 fade-in">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                    <div>
                        <p class="text-base text-gray-500">Analisis Lengkap untuk:</p>
                        <h1 class="text-3xl font-extrabold text-navy tracking-tight">{{ $pesertaDidik->nama_lengkap }}
                        </h1>
                        <p class="text-gray-600 mt-1">NISN: {{ $pesertaDidik->nisn }}</p>
                    </div>
                    <div class="w-full md:w-auto flex items-center space-x-6 bg-gray-50 p-4 rounded-xl border">
                        <div class="text-center">
                            <p class="text-sm text-gray-500">Nilai Preferensi</p>
                            <p class="text-2xl font-bold text-navy">
                                {{ number_format($perhitungan->nilai_preferensi, 4) }}</p>
                        </div>
                        <div class="border-l h-10"></div>
                        <div class="text-center">
                            <p class="text-sm text-gray-500">Rekomendasi</p>
                            <span
                                class="text-lg font-bold {{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'text-blue-600' : 'text-green-600' }}">
                                {{ $perhitungan->jurusan_rekomendasi }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 fade-in fade-in-delay-1">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
                    <h3 class="text-xl font-bold text-navy mb-6">📚 Analisis Akademik</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-4 border-b">
                            <span class="text-sm font-medium text-gray-600">Rata-rata Nilai</span>
                            <span
                                class="font-bold text-xl text-navy">{{ number_format($analysis['nilai_akademik']['rata_rata'], 1) }}</span>
                        </div>
                        @foreach (['ipa' => 'IPA', 'ips' => 'IPS', 'matematika' => 'Matematika', 'bahasa_indonesia' => 'B. Indonesia', 'bahasa_inggris' => 'B. Inggris', 'produktif' => 'PKN'] as $key => $label)
                            <div class="space-y-2">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-600">{{ $label }}</span>
                                    <span class="font-bold">{{ $analysis['nilai_akademik'][$key] }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                    <div class="bg-{{ $analysis['nilai_akademik'][$key] >= 85 ? 'green' : ($analysis['nilai_akademik'][$key] >= 75 ? 'blue' : 'orange') }}-500 h-1.5 rounded-full"
                                        style="width: {{ $analysis['nilai_akademik'][$key] }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
                    <h3 class="text-xl font-bold text-navy mb-6">🎯 Analisis Minat & Faktor Lain</h3>
                    <div class="space-y-3">
                        @foreach ($analysis['minat'] as $key => $value)
                            <div
                                class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <p class="text-sm text-gray-600 font-medium">{{ $value }}</p>
                                <span class="text-xs font-bold text-gray-400">{{ strtoupper($key) }}</span>
                            </div>
                        @endforeach
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="text-sm text-gray-600 font-medium">{{ $analysis['keahlian'] }}</p>
                            <span class="text-xs font-bold text-gray-400">KEAHLIAN</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="text-sm text-gray-600 font-medium">{{ $analysis['biaya_gelombang'] }}</p>
                            <span class="text-xs font-bold text-gray-400">BIAYA</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 fade-in fade-in-delay-2">
                <h3 class="text-2xl font-extrabold text-navy tracking-tight mb-6">Rangkuman & Rekomendasi Aksi</h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <h4 class="font-bold text-lg text-gray-800 mb-3">💪 Kekuatan Utama</h4>
                            @if (count($strengthWeakness['strengths']) > 0)
                                <ul class="space-y-2">
                                    @foreach ($strengthWeakness['strengths'] as $strength)
                                        <li class="flex items-start space-x-3">
                                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-sm text-gray-700">{{ $strength }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-sm text-gray-500">Tidak ada kekuatan khusus teridentifikasi.</p>
                            @endif
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-gray-800 mb-3">📈 Area Pengembangan</h4>
                            @if (count($strengthWeakness['weaknesses']) > 0)
                                <ul class="space-y-2">
                                    @foreach ($strengthWeakness['weaknesses'] as $weakness)
                                        <li class="flex items-start space-x-3">
                                            <svg class="w-5 h-5 text-orange-500 mt-0.5 flex-shrink-0"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-sm text-gray-700">{{ $weakness }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-sm text-gray-500">Tidak ada kelemahan signifikan teridentifikasi.</p>
                            @endif
                        </div>
                    </div>
                    <div>
                        <h4 class="font-bold text-lg text-gray-800 mb-3">💡 Saran Pengembangan</h4>
                        <div class="space-y-3">
                            @foreach ($suggestions as $suggestion)
                                <div
                                    class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg border border-blue-100">
                                    <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                        </path>
                                    </svg>
                                    <span class="text-sm text-blue-800">{{ $suggestion }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 fade-in fade-in-delay-4">
                <a href="{{ route('rekomendasi.analisis', $pesertaDidik->nisn) }}"
                    class="bg-white border-2 border-navy text-navy px-6 py-4 rounded-xl hover:bg-navy hover:text-white transition text-center font-bold text-lg flex items-center justify-center gap-2">
                    <span>📊</span>
                    <span>Lihat Detail Perhitungan</span>
                </a>
                <a href="{{ route('rekomendasi.index') }}"
                    class="bg-gray-200 text-gray-800 px-6 py-4 rounded-xl hover:bg-gray-300 transition text-center font-bold text-lg flex items-center justify-center gap-2">
                    <span>🔍</span>
                    <span>Cari NISN Lain</span>
                </a>
            </div>
        </div>
    </div>

    <footer class="bg-white border-t border-gray-200 py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-600">
            <p>&copy; {{ date('Y') }} SMK Penida 2 Katapang. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
