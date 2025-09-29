<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisis Lengkap - {{ $pesertaDidik->nama_lengkap }}</title>
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
    <style>
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-navy rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">SP</span>
                    </div>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">SPK Pemilihan Jurusan</h1>
                        <p class="text-xs text-gray-500">Analisis Mendalam</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('rekomendasi.show', $pesertaDidik->nisn) }}"
                        class="text-navy hover:text-navy-dark text-sm font-medium">
                        ← Kembali
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-8">

            <!-- Header -->
            <div
                class="bg-gradient-to-r from-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-600 to-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-700 rounded-2xl p-8 text-white fade-in">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                @if ($perhitungan->jurusan_rekomendasi === 'TKJ')
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                                    </svg>
                                @else
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold mb-2">Analisis Mendalam Rekomendasi</h1>
                                <p class="text-xl text-white text-opacity-90">
                                    {{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'Teknik Komputer dan Jaringan' : 'Teknik Kendaraan Ringan' }}
                                </p>
                            </div>
                        </div>
                        <div class="text-lg">
                            Nilai Preferensi: <span
                                class="font-bold text-2xl">{{ number_format($perhitungan->nilai_preferensi, 4) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analisis Akademik & Minat -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 fade-in">
                <!-- Academic Performance -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                    <h3 class="text-xl font-bold text-navy mb-6">📚 Analisis Akademik</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-4 border-b">
                            <span class="text-sm font-medium text-gray-600">Rata-rata Nilai</span>
                            <span
                                class="font-bold text-xl text-navy">{{ number_format($analysis['nilai_akademik']['rata_rata'], 1) }}</span>
                        </div>

                        @foreach (['ipa' => 'IPA', 'ips' => 'IPS', 'matematika' => 'Matematika', 'bahasa_indonesia' => 'B. Indonesia', 'bahasa_inggris' => 'B. Inggris', 'produktif' => 'PKN'] as $key => $label)
                            <div class="space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">{{ $label }}</span>
                                    <span class="text-sm font-bold">{{ $analysis['nilai_akademik'][$key] }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-{{ $analysis['nilai_akademik'][$key] >= 85 ? 'green' : ($analysis['nilai_akademik'][$key] >= 75 ? 'blue' : 'orange') }}-500 h-2.5 rounded-full transition-all"
                                        style="width: {{ $analysis['nilai_akademik'][$key] }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Interest Analysis -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                    <h3 class="text-xl font-bold text-navy mb-6">🎯 Analisis Minat</h3>
                    <div class="space-y-3">
                        @foreach ($analysis['minat'] as $key => $value)
                            <div
                                class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <div class="flex-1">
                                    <span class="text-sm font-semibold text-gray-700">{{ strtoupper($key) }}</span>
                                    <p class="text-sm text-gray-600 mt-1">{{ $value }}</p>
                                </div>
                                @php
                                    $teknologiInterests = [
                                        'Teknologi informasi & Komunikasi',
                                        'Komputer',
                                        'Desain Grafis',
                                        'Fotografi & Videografi',
                                    ];
                                    $isTeknologi = in_array($value, $teknologiInterests);
                                @endphp
                                <div class="w-4 h-4 rounded-full bg-{{ $isTeknologi ? 'blue' : 'green' }}-400"></div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-200">
                        <div class="flex items-center justify-around text-sm">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-blue-400 rounded-full mr-2"></div>
                                <span class="text-blue-700">Teknologi</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-400 rounded-full mr-2"></div>
                                <span class="text-green-700">Teknik</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kekuatan & Kelemahan -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 fade-in">
                <!-- Strengths -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-navy">💪 Kekuatan Anda</h3>
                    </div>

                    @if (count($strengthWeakness['strengths']) > 0)
                        <div class="space-y-3">
                            @foreach ($strengthWeakness['strengths'] as $strength)
                                <div
                                    class="flex items-start space-x-3 p-4 bg-green-50 rounded-xl border border-green-200">
                                    <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-green-800 font-medium">{{ $strength }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">Tidak ada kekuatan khusus teridentifikasi</p>
                    @endif
                </div>

                <!-- Weaknesses -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-1.964-1.333-2.732 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-navy">📈 Area Pengembangan</h3>
                    </div>

                    @if (count($strengthWeakness['weaknesses']) > 0)
                        <div class="space-y-3">
                            @foreach ($strengthWeakness['weaknesses'] as $weakness)
                                <div
                                    class="flex items-start space-x-3 p-4 bg-orange-50 rounded-xl border border-orange-200">
                                    <svg class="w-5 h-5 text-orange-600 mt-0.5 flex-shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-orange-800 font-medium">{{ $weakness }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">Tidak ada kelemahan signifikan teridentifikasi</p>
                    @endif
                </div>
            </div>

            <!-- Saran Pengembangan -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 fade-in">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-navy">💡 Saran Pengembangan</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($suggestions as $index => $suggestion)
                        <div class="flex items-start space-x-3 p-4 bg-blue-50 rounded-xl border border-blue-200">
                            <div
                                class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">
                                {{ $index + 1 }}
                            </div>
                            <span class="text-sm text-blue-800">{{ $suggestion }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Langkah Selanjutnya -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl p-8 border border-gray-200 fade-in">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-navy rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-navy">🎯 Langkah Selanjutnya</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-6 bg-white rounded-xl border border-gray-200 text-center">
                        <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-blue-600 font-bold text-xl">1</span>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Konsultasi</h4>
                        <p class="text-sm text-gray-600">Diskusikan hasil dengan guru BK dan orang tua</p>
                    </div>

                    <div class="p-6 bg-white rounded-xl border border-gray-200 text-center">
                        <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-green-600 font-bold text-xl">2</span>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Eksplorasi</h4>
                        <p class="text-sm text-gray-600">Pelajari lebih dalam tentang jurusan yang direkomendasikan</p>
                    </div>

                    <div class="p-6 bg-white rounded-xl border border-gray-200 text-center">
                        <div
                            class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-purple-600 font-bold text-xl">3</span>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Persiapan</h4>
                        <p class="text-sm text-gray-600">Mulai persiapkan diri sesuai saran pengembangan</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 fade-in">
                <a href="{{ route('rekomendasi.show', $pesertaDidik->nisn) }}"
                    class="bg-navy text-white px-6 py-4 rounded-xl hover:bg-navy-dark transition text-center font-semibold">
                    ← Hasil Rekomendasi
                </a>
                <a href="{{ route('rekomendasi.analisis', $pesertaDidik->nisn) }}"
                    class="bg-white border-2 border-navy text-navy px-6 py-4 rounded-xl hover:bg-navy hover:text-white transition text-center font-semibold">
                    📊 Detail Perhitungan TOPSIS
                </a>
                <a href="{{ route('rekomendasi.index') }}"
                    class="bg-gray-500 text-white px-6 py-4 rounded-xl hover:bg-gray-600 transition text-center font-semibold">
                    🔍 Cari NISN Lain
                </a>
            </div>

            <!-- Disclaimer -->
            <div class="bg-yellow-50 border-2 border-yellow-200 rounded-2xl p-6 fade-in">
                <div class="flex items-start space-x-4">
                    <svg class="w-6 h-6 text-yellow-600 mt-1 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-1.964-1.333-2.732 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <h4 class="font-bold text-yellow-900 mb-3">⚠️ Catatan Penting</h4>
                        <ul class="text-sm text-yellow-800 space-y-2">
                            <li>• Hasil rekomendasi ini bersifat informatif dan merupakan bantuan dalam pengambilan
                                keputusan</li>
                            <li>• Keputusan akhir tetap berada di tangan Anda dengan pertimbangan berbagai faktor
                                lainnya</li>
                            <li>• Konsultasikan dengan guru, orang tua, dan pihak yang berpengalaman sebelum memutuskan
                            </li>
                            <li>• Terus kembangkan kemampuan Anda di bidang yang diminati</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-600">
            <p>&copy; 2024 SMK Penida 2 Katapang. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
