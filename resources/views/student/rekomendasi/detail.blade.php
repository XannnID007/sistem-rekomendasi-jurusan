@extends('layouts.student')

@section('title', 'Detail Rekomendasi')
@section('page-title', 'Analisis Mendalam Rekomendasi')
@section('page-description', 'Analisis komprehensif dan saran pengembangan berdasarkan hasil TOPSIS')

@section('content')
    <div class="space-y-6">
        <!-- Main Result Header -->
        <div
            class="bg-gradient-to-r from-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-600 to-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-700 rounded-xl p-8 text-white">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
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
                            <h1 class="text-3xl font-bold mb-2">Rekomendasi Akhir</h1>
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

        <!-- Detailed Analysis -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Academic Performance Analysis -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-navy mb-4">Analisis Akademik</h3>

                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Rata-rata Nilai</span>
                        <span
                            class="font-bold text-lg">{{ number_format($analysis['nilai_akademik']['rata_rata'], 1) }}</span>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        @foreach (['ipa' => 'IPA', 'ips' => 'IPS', 'matematika' => 'MTK', 'bahasa_indonesia' => 'B.IND', 'bahasa_inggris' => 'B.ING', 'produktif' => 'PROD'] as $key => $label)
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-600">{{ $label }}:</span>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-medium">{{ $analysis['nilai_akademik'][$key] }}</span>
                                    <div class="w-8 h-2 bg-gray-200 rounded-full">
                                        <div class="h-2 bg-{{ $analysis['nilai_akademik'][$key] >= 85 ? 'green' : ($analysis['nilai_akademik'][$key] >= 75 ? 'yellow' : 'red') }}-400 rounded-full"
                                            style="width: {{ $analysis['nilai_akademik'][$key] }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Interest Analysis -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-navy mb-4">Analisis Minat</h3>

                <div class="space-y-3">
                    @foreach ($analysis['minat'] as $key => $value)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <span class="text-sm font-medium">{{ strtoupper($key) }}:</span>
                                <span class="text-sm text-gray-600 ml-2">{{ $value }}</span>
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
                            <div class="w-3 h-3 rounded-full bg-{{ $isTeknologi ? 'blue' : 'green' }}-400"></div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm text-blue-700">
                        <span class="w-3 h-3 bg-blue-400 rounded-full inline-block mr-2"></span>Teknologi & Komputer
                        <span class="w-3 h-3 bg-green-400 rounded-full inline-block mr-2 ml-4"></span>Teknik & Mesin
                    </p>
                </div>
            </div>
        </div>

        <!-- Strengths and Weaknesses -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Strengths -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-navy">Kekuatan Anda</h3>
                </div>

                @if (count($strengthWeakness['strengths']) > 0)
                    <div class="space-y-3">
                        @foreach ($strengthWeakness['strengths'] as $strength)
                            <div class="flex items-start space-x-3 p-3 bg-green-50 rounded-lg">
                                <svg class="w-4 h-4 text-green-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-green-800">{{ $strength }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">Tidak ada kekuatan khusus yang teridentifikasi dari data saat ini.</p>
                @endif
            </div>

            <!-- Weaknesses -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-navy">Area Pengembangan</h3>
                </div>

                @if (count($strengthWeakness['weaknesses']) > 0)
                    <div class="space-y-3">
                        @foreach ($strengthWeakness['weaknesses'] as $weakness)
                            <div class="flex items-start space-x-3 p-3 bg-orange-50 rounded-lg">
                                <svg class="w-4 h-4 text-orange-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-orange-800">{{ $weakness }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">Tidak ada kelemahan yang signifikan teridentifikasi dari nilai
                        akademik.</p>
                @endif
            </div>
        </div>

        <!-- Improvement Suggestions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-navy">Saran Pengembangan</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($suggestions as $index => $suggestion)
                    <div class="flex items-start space-x-3 p-4 bg-blue-50 rounded-lg">
                        <div
                            class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold mt-0.5">
                            {{ $index + 1 }}
                        </div>
                        <span class="text-sm text-blue-800">{{ $suggestion }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Additional Resources -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-navy mb-4">Sumber Daya Tambahan</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if ($perhitungan->jurusan_rekomendasi === 'TKJ')
                    <!-- TKJ Resources -->
                    <div>
                        <h4 class="font-medium text-blue-800 mb-3">Untuk Jurusan TKJ</h4>
                        <div class="space-y-2">
                            <a href="#"
                                class="flex items-center space-x-2 text-sm text-blue-600 hover:text-blue-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                <span>Panduan Lengkap Jurusan TKJ</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 text-sm text-blue-600 hover:text-blue-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.168 18.477 18.582 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <span>Kurikulum dan Mata Pelajaran TKJ</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 text-sm text-blue-600 hover:text-blue-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 00-2 2H6a2 2 0 00-2-2V6m8 0H8m8 0l2 2-2 2M8 6L6 8l2 2" />
                                </svg>
                                <span>Prospek Karir Lulusan TKJ</span>
                            </a>
                        </div>
                    </div>
                @else
                    <!-- TKR Resources -->
                    <div>
                        <h4 class="font-medium text-green-800 mb-3">Untuk Jurusan TKR</h4>
                        <div class="space-y-2">
                            <a href="#"
                                class="flex items-center space-x-2 text-sm text-green-600 hover:text-green-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                <span>Panduan Lengkap Jurusan TKR</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 text-sm text-green-600 hover:text-green-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.168 18.477 18.582 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <span>Kurikulum dan Mata Pelajaran TKR</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-2 text-sm text-green-600 hover:text-green-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 00-2 2H6a2 2 0 00-2-2V6m8 0H8m8 0l2 2-2 2M8 6L6 8l2 2" />
                                </svg>
                                <span>Prospek Karir Lulusan TKR</span>
                            </a>
                        </div>
                    </div>
                @endif

                <!-- General Resources -->
                <div>
                    <h4 class="font-medium text-gray-800 mb-3">Sumber Daya Umum</h4>
                    <div class="space-y-2">
                        <a href="#" class="flex items-center space-x-2 text-sm text-gray-600 hover:text-gray-800">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Konsultasi dengan Guru BK</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 text-sm text-gray-600 hover:text-gray-800">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                            <span>Diskusi dengan Alumni</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 text-sm text-gray-600 hover:text-gray-800">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span>Kunjungan Industri</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 text-sm text-gray-600 hover:text-gray-800">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.168 18.477 18.582 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span>Panduan Persiapan Kuliah/Kerja</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-8 h-8 bg-navy rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-navy">Langkah Selanjutnya</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 bg-white rounded-lg border border-gray-200">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-blue-600 font-bold text-lg">1</span>
                        </div>
                        <h4 class="font-medium text-gray-900 mb-2">Konsultasi</h4>
                        <p class="text-sm text-gray-600">Diskusikan hasil dengan guru BK dan orang tua</p>
                    </div>
                </div>

                <div class="p-4 bg-white rounded-lg border border-gray-200">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-green-600 font-bold text-lg">2</span>
                        </div>
                        <h4 class="font-medium text-gray-900 mb-2">Eksplorasi</h4>
                        <p class="text-sm text-gray-600">Pelajari lebih dalam tentang jurusan yang direkomendasikan</p>
                    </div>
                </div>

                <div class="p-4 bg-white rounded-lg border border-gray-200">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-purple-600 font-bold text-lg">3</span>
                        </div>
                        <h4 class="font-medium text-gray-900 mb-2">Persiapan</h4>
                        <p class="text-sm text-gray-600">Mulai persiapkan diri sesuai saran pengembangan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('student.rekomendasi.index') }}"
                class="flex-1 bg-navy text-white px-6 py-3 rounded-lg hover:bg-navy-dark transition duration-200 text-center font-medium">
                Kembali ke Rekomendasi
            </a>
            <a href="{{ route('student.analisis.index') }}"
                class="flex-1 bg-white border border-navy text-navy px-6 py-3 rounded-lg hover:bg-navy hover:text-white transition duration-200 text-center font-medium">
                Lihat Detail Analisis
            </a>
            <a href="{{ route('student.profil.index') }}"
                class="flex-1 bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition duration-200 text-center font-medium">
                Lihat Profil
            </a>
        </div>

        <!-- Disclaimer -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
            <div class="flex items-start space-x-3">
                <svg class="w-6 h-6 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
                <div>
                    <h4 class="font-medium text-yellow-800 mb-2">Catatan Penting</h4>
                    <div class="text-sm text-yellow-700 space-y-1">
                        <p>• Hasil rekomendasi ini bersifat informatif dan merupakan bantuan dalam pengambilan keputusan</p>
                        <p>• Keputusan akhir tetap berada di tangan Anda dengan pertimbangan berbagai faktor lainnya</p>
                        <p>• Konsultasikan dengan guru, orang tua, dan pihak yang berpengalaman sebelum memutuskan</p>
                        <p>• Terus kembangkan kemampuan Anda di bidang yang diminati</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Add any interactive features for the detail page
            console.log('Recommendation detail page loaded');
        </script>
    @endpush
@endsection
