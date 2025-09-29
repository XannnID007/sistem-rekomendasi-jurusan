<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Rekomendasi - {{ $pesertaDidik->nama_lengkap }}</title>
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
                        <p class="text-xs text-gray-500">Hasil Rekomendasi</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('rekomendasi.index') }}"
                        class="text-navy hover:text-navy-dark text-sm font-medium">
                        ← Cari Lagi
                    </a>
                    <a href="{{ route('welcome') }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                        Beranda
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            @if ($hasCalculation)
                <!-- Main Result Card -->
                <div
                    class="bg-gradient-to-r from-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-600 to-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-700 rounded-2xl p-8 text-white mb-8 fade-in">
                    <div class="flex flex-col lg:flex-row items-center justify-between">
                        <div class="flex-1 mb-6 lg:mb-0">
                            <div class="flex items-center space-x-4 mb-6">
                                <div
                                    class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                    @if ($perhitungan->jurusan_rekomendasi === 'TKJ')
                                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                                        </svg>
                                    @else
                                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <h1 class="text-3xl font-bold mb-2">{{ $pesertaDidik->nama_lengkap }}</h1>
                                    <p class="text-xl text-white text-opacity-90">NISN: {{ $pesertaDidik->nisn }}</p>
                                </div>
                            </div>
                            <div class="bg-white bg-opacity-10 rounded-xl p-6">
                                <p class="text-sm text-white text-opacity-80 mb-2">Rekomendasi Jurusan</p>
                                <h2 class="text-3xl font-bold mb-2">
                                    {{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'Teknik Komputer dan Jaringan' : 'Teknik Kendaraan Ringan' }}
                                </h2>
                                <p class="text-white text-opacity-90">({{ $perhitungan->jurusan_rekomendasi }})</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 lg:ml-8">
                            <div class="bg-white bg-opacity-10 rounded-xl p-6 text-center">
                                <p class="text-sm text-white text-opacity-80 mb-2">Nilai Preferensi</p>
                                <p class="text-3xl font-bold">{{ number_format($perhitungan->nilai_preferensi, 4) }}</p>
                            </div>
                            <div class="bg-white bg-opacity-10 rounded-xl p-6 text-center">
                                <p class="text-sm text-white text-opacity-80 mb-2">Peringkat</p>
                                <p class="text-3xl font-bold">{{ $ranking }}/{{ $totalStudents }}</p>
                            </div>
                            <div class="bg-white bg-opacity-10 rounded-xl p-6 text-center col-span-2">
                                <p class="text-sm text-white text-opacity-80 mb-2">Persentil</p>
                                <p class="text-3xl font-bold">Top {{ $percentile }}%</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Explanation Card -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 mb-8 fade-in">
                    <div class="flex items-start space-x-4">
                        <div
                            class="w-12 h-12 bg-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-600"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-navy mb-4">Penjelasan Rekomendasi</h3>
                            <p class="text-gray-700 mb-4 leading-relaxed">{{ $explanation['reason'] }}</p>
                            <p class="text-gray-600 leading-relaxed">{{ $explanation['description'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Career Prospects -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 mb-8 fade-in">
                    <h3 class="text-xl font-bold text-navy mb-6">Prospek Karir</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($explanation['career_prospects'] as $career)
                            <div
                                class="flex items-center space-x-3 p-4 bg-gray-50 rounded-xl border border-gray-200 hover:shadow-md transition">
                                <div
                                    class="w-10 h-10 bg-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-600"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m8 0h-8m8 0v1.5a2 2 0 002 2h0a2 2 0 002-2V6z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ $career }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 fade-in">
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Rata-rata Kelas</p>
                                <p class="text-2xl font-bold text-navy">{{ number_format($avgPreference, 4) }}</p>
                                <p class="text-sm mt-2">
                                    @if ($perhitungan->nilai_preferensi > $avgPreference)
                                        <span class="text-green-600 font-medium">✓ Di atas rata-rata</span>
                                    @else
                                        <span class="text-orange-600 font-medium">→ Di bawah rata-rata</span>
                                    @endif
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Teman Sejurusan</p>
                                <p class="text-2xl font-bold text-navy">{{ $sameRecommendation }}</p>
                                <p class="text-sm text-gray-500 mt-2">Siswa dengan rekomendasi
                                    {{ $perhitungan->jurusan_rekomendasi }}</p>
                            </div>
                            <div
                                class="w-12 h-12 bg-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-600"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Threshold TOPSIS</p>
                                <p class="text-2xl font-bold text-navy">0.30</p>
                                <p class="text-sm text-gray-500 mt-2">
                                    {{ $perhitungan->nilai_preferensi > 0.3 ? 'TKJ (> 0.30)' : 'TKR (≤ 0.30)' }}</p>
                            </div>
                            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8 fade-in">
                    <a href="{{ route('rekomendasi.detail', $pesertaDidik->nisn) }}"
                        class="bg-navy text-white px-8 py-4 rounded-xl hover:bg-navy-dark transition duration-200 text-center font-semibold text-lg shadow-lg">
                        📊 Lihat Analisis Lengkap
                    </a>
                    <a href="{{ route('rekomendasi.analisis', $pesertaDidik->nisn) }}"
                        class="bg-white border-2 border-navy text-navy px-8 py-4 rounded-xl hover:bg-navy hover:text-white transition duration-200 text-center font-semibold text-lg shadow-lg">
                        🔍 Detail Perhitungan TOPSIS
                    </a>
                </div>

                <!-- Important Notes -->
                <div class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-6 fade-in">
                    <div class="flex items-start space-x-4">
                        <svg class="w-6 h-6 text-blue-600 mt-1 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <h4 class="font-bold text-blue-900 mb-3">Catatan Penting</h4>
                            <ul class="text-sm text-blue-800 space-y-2">
                                <li>• Rekomendasi ini dihasilkan berdasarkan analisis metode TOPSIS dengan 12 kriteria
                                </li>
                                <li>• Mencakup nilai akademik, minat, keahlian, dan latar belakang ekonomi</li>
                                <li>• Hasil ini merupakan panduan untuk membantu dalam memilih jurusan yang sesuai</li>
                                <li>• Keputusan akhir tetap berada di tangan siswa dan orang tua</li>
                                <li>• Konsultasikan dengan guru BK untuk mendapatkan saran yang lebih personal</li>
                            </ul>
                        </div>
                    </div>
                </div>
            @else
                <!-- No Data Available -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-12 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Belum Ada Rekomendasi</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        Rekomendasi jurusan untuk <strong>{{ $pesertaDidik->nama_lengkap }}</strong> belum tersedia.
                        Data penilaian perlu diinput dan dihitung terlebih dahulu oleh admin.
                    </p>
                    <div class="space-y-4">
                        <p class="text-sm text-gray-500">
                            <strong>Status:</strong>
                            @if (!$hasPenilaian)
                                <span class="text-orange-600">Menunggu input data penilaian</span>
                            @else
                                <span class="text-blue-600">Menunggu perhitungan TOPSIS</span>
                            @endif
                        </p>
                        <a href="{{ route('rekomendasi.index') }}"
                            class="inline-block bg-navy text-white px-6 py-3 rounded-xl hover:bg-navy-dark transition duration-200 font-semibold">
                            Kembali ke Pencarian
                        </a>
                    </div>
                </div>
            @endif
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
