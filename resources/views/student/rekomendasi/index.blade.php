@extends('layouts.student')

@section('title', 'Hasil Rekomendasi')
@section('page-title', 'Hasil Rekomendasi Jurusan')
@section('page-description', 'Rekomendasi jurusan berdasarkan analisis TOPSIS')

@section('content')
    @if ($hasRecommendation)
        <div class="space-y-6">
            <!-- Main Recommendation Card -->
            <div
                class="bg-gradient-to-r from-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-600 to-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-700 rounded-xl p-8 text-white">
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
                                <h1 class="text-3xl font-bold mb-2">
                                    {{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'Teknik Komputer dan Jaringan' : 'Teknik Kendaraan Ringan' }}
                                </h1>
                                <p class="text-xl text-white text-opacity-90">
                                    Jurusan yang direkomendasikan untuk Anda
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                            <div class="bg-white bg-opacity-10 rounded-lg p-4">
                                <p class="text-sm text-white text-opacity-80 mb-1">Nilai Preferensi</p>
                                <p class="text-2xl font-bold">{{ number_format($perhitungan->nilai_preferensi, 4) }}</p>
                            </div>
                            <div class="bg-white bg-opacity-10 rounded-lg p-4">
                                <p class="text-sm text-white text-opacity-80 mb-1">Peringkat Anda</p>
                                <p class="text-2xl font-bold">{{ $ranking }} dari {{ $totalStudents }}</p>
                            </div>
                            <div class="bg-white bg-opacity-10 rounded-lg p-4">
                                <p class="text-sm text-white text-opacity-80 mb-1">Persentil</p>
                                <p class="text-2xl font-bold">{{ $percentile }}%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Explanation Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-start space-x-4">
                    <div
                        class="w-12 h-12 bg-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-600"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-navy mb-2">Penjelasan Rekomendasi</h3>
                        <p class="text-gray-700 mb-4">{{ $explanation['reason'] }}</p>
                        <p class="text-gray-600">{{ $explanation['description'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Career Prospects -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-navy mb-4">Prospek Karir</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($explanation['career_prospects'] as $career)
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                            <div
                                class="w-8 h-8 bg-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-600"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 00-2 2H6a2 2 0 00-2-2V6m8 0H8m8 0l2 2-2 2M8 6L6 8l2 2" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700">{{ $career }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Rata-rata Kelas</p>
                            <p class="text-2xl font-bold text-navy">{{ number_format($avgPreference, 4) }}</p>
                            <p class="text-sm text-gray-500 mt-1">
                                @if ($perhitungan->nilai_preferensi > $avgPreference)
                                    <span class="text-green-600">Di atas rata-rata</span>
                                @else
                                    <span class="text-orange-600">Di bawah rata-rata</span>
                                @endif
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 00-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Teman Satu Jurusan</p>
                            <p class="text-2xl font-bold text-navy">{{ $sameRecommendation }}</p>
                            <p class="text-sm text-gray-500 mt-1">Siswa dengan rekomendasi
                                {{ $perhitungan->jurusan_rekomendasi }}</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-600"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Threshold TOPSIS</p>
                            <p class="text-2xl font-bold text-navy">0.30</p>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $perhitungan->nilai_preferensi > 0.3 ? 'TKJ (> 0.30)' : 'TKR (≤ 0.30)' }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('student.rekomendasi.detail') }}"
                    class="flex-1 bg-navy text-white px-6 py-3 rounded-lg hover:bg-navy-dark transition duration-200 text-center font-medium">
                    Lihat Analisis Lengkap
                </a>
                <a href="{{ route('student.analisis.index') }}"
                    class="flex-1 bg-white border border-navy text-navy px-6 py-3 rounded-lg hover:bg-navy hover:text-white transition duration-200 text-center font-medium">
                    Detail Perhitungan TOPSIS
                </a>
            </div>

            <!-- Additional Information -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h4 class="font-medium text-blue-800 mb-2">Catatan Penting</h4>
                        <div class="text-sm text-blue-700 space-y-2">
                            <p>• Rekomendasi ini dihasilkan berdasarkan analisis metode TOPSIS dengan 12 kriteria yang
                                mencakup nilai akademik, minat, keahlian, dan latar belakang ekonomi.</p>
                            <p>• Hasil ini merupakan panduan untuk membantu Anda dalam memilih jurusan yang sesuai, namun
                                keputusan akhir tetap ada di tangan Anda.</p>
                            <p>• Konsultasikan dengan guru BK atau orang tua untuk mendapatkan saran yang lebih personal.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- No Recommendation Available -->
        <div class="min-h-96 flex items-center justify-center">
            <div class="text-center max-w-md mx-auto">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Belum Ada Rekomendasi</h3>
                <p class="text-gray-600 mb-6">
                    Rekomendasi jurusan belum tersedia. Data penilaian Anda perlu diinput dan dihitung terlebih dahulu oleh
                    admin.
                </p>
                <div class="space-y-3">
                    <p class="text-sm text-gray-500">
                        <strong>Status saat ini:</strong>
                        @if (!$pesertaDidik->penilaianTerbaru)
                            Menunggu input data penilaian
                        @else
                            Menunggu perhitungan TOPSIS
                        @endif
                    </p>
                    <a href="{{ route('student.dashboard') }}"
                        class="inline-flex items-center px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy-dark transition duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    @endif

@endsection
