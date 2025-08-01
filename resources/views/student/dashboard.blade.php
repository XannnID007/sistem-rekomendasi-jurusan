@extends('layouts.student')

@section('title', 'Dashboard Siswa')
@section('page-title', 'Dashboard')
@section('page-description', 'Selamat datang, ' . $pesertaDidik->nama_lengkap)

@section('content')
    <div class="space-y-6">
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-navy to-navy-dark rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Selamat Datang, {{ $pesertaDidik->nama_lengkap }}!</h2>
                    <p class="text-blue-100 mb-4">NISN: {{ $pesertaDidik->nisn }} • Tahun Ajaran:
                        {{ $pesertaDidik->tahun_ajaran }}</p>
                    <div class="flex items-center space-x-4">
                        <div class="text-sm">
                            <span class="text-blue-200">Kelengkapan Profil:</span>
                            <span class="font-bold">{{ $profileCompletion }}%</span>
                        </div>
                        <div class="w-32 bg-blue-700 rounded-full h-2">
                            <div class="bg-gold h-2 rounded-full" style="width: {{ $profileCompletion }}%"></div>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="w-24 h-24 bg-gold rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-navy" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Assessment Status -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Status Penilaian</p>
                        <p class="text-2xl font-bold text-navy mt-1">
                            {{ $hasPenilaian ? 'Lengkap' : 'Belum Ada' }}
                        </p>
                        @if ($hasPenilaian)
                            <p class="text-sm text-green-600 mt-1">Data penilaian tersedia</p>
                        @else
                            <p class="text-sm text-red-600 mt-1">Menunggu input data</p>
                        @endif
                    </div>
                    <div
                        class="w-12 h-12 {{ $hasPenilaian ? 'bg-green-50' : 'bg-red-50' }} rounded-lg flex items-center justify-center">
                        @if ($hasPenilaian)
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @else
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Calculation Status -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Status Perhitungan</p>
                        <p class="text-2xl font-bold text-navy mt-1">
                            {{ $hasCalculation ? 'Selesai' : 'Belum Dihitung' }}
                        </p>
                        @if ($hasCalculation)
                            <p class="text-sm text-green-600 mt-1">Perhitungan TOPSIS selesai</p>
                        @else
                            <p class="text-sm text-orange-600 mt-1">Menunggu perhitungan</p>
                        @endif
                    </div>
                    <div
                        class="w-12 h-12 {{ $hasCalculation ? 'bg-green-50' : 'bg-orange-50' }} rounded-lg flex items-center justify-center">
                        @if ($hasCalculation)
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        @else
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recommendation Status -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Rekomendasi Jurusan</p>
                        @if ($rekomendasi)
                            <p
                                class="text-2xl font-bold {{ $rekomendasi === 'TKJ' ? 'text-blue-600' : 'text-green-600' }} mt-1">
                                {{ $rekomendasi }}
                            </p>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ $rekomendasi === 'TKJ' ? 'Teknik Komputer & Jaringan' : 'Teknik Kendaraan Ringan' }}
                            </p>
                        @else
                            <p class="text-2xl font-bold text-gray-400 mt-1">-</p>
                            <p class="text-sm text-gray-500 mt-1">Belum tersedia</p>
                        @endif
                    </div>
                    <div
                        class="w-12 h-12 {{ $rekomendasi ? ($rekomendasi === 'TKJ' ? 'bg-blue-50' : 'bg-green-50') : 'bg-gray-50' }} rounded-lg flex items-center justify-center">
                        @if ($rekomendasi === 'TKJ')
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                            </svg>
                        @elseif($rekomendasi === 'TKR')
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        @else
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if ($hasCalculation)
            <!-- Recommendation Detail Card -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-navy">Hasil Rekomendasi Anda</h3>
                    <a href="{{ route('student.rekomendasi.index') }}"
                        class="text-navy hover:text-navy-dark font-medium text-sm">
                        Lihat Detail →
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Nilai Preferensi</p>
                        <p class="text-2xl font-bold text-navy">{{ number_format($nilaiPreferensi, 4) }}</p>
                        <p class="text-xs text-gray-500 mt-1">Skor TOPSIS</p>
                    </div>

                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Peringkat</p>
                        <p class="text-2xl font-bold text-navy">{{ $ranking }}</p>
                        <p class="text-xs text-gray-500 mt-1">dari {{ $totalStudents }} siswa</p>
                    </div>

                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Rekomendasi</p>
                        <p class="text-2xl font-bold {{ $rekomendasi === 'TKJ' ? 'text-blue-600' : 'text-green-600' }}">
                            {{ $rekomendasi }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $rekomendasi === 'TKJ' ? 'Teknik Komputer & Jaringan' : 'Teknik Kendaraan Ringan' }}
                        </p>
                    </div>
                </div>

                <div
                    class="mt-6 p-4 {{ $rekomendasi === 'TKJ' ? 'bg-blue-50 border border-blue-200' : 'bg-green-50 border border-green-200' }} rounded-lg">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 {{ $rekomendasi === 'TKJ' ? 'text-blue-600' : 'text-green-600' }} mt-0.5"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <h4
                                class="font-medium {{ $rekomendasi === 'TKJ' ? 'text-blue-800' : 'text-green-800' }} mb-1">
                                Rekomendasi:
                                {{ $rekomendasi === 'TKJ' ? 'Teknik Komputer dan Jaringan' : 'Teknik Kendaraan Ringan' }}
                            </h4>
                            <p class="text-sm {{ $rekomendasi === 'TKJ' ? 'text-blue-700' : 'text-green-700' }}">
                                @if ($rekomendasi === 'TKJ')
                                    Berdasarkan analisis TOPSIS, Anda menunjukkan kesesuaian yang baik dengan jurusan TKJ.
                                    Nilai preferensi Anda ({{ number_format($nilaiPreferensi, 4) }}) berada di atas
                                    threshold 0.30.
                                @else
                                    Berdasarkan analisis TOPSIS, Anda menunjukkan kesesuaian yang baik dengan jurusan TKR.
                                    Nilai preferensi Anda ({{ number_format($nilaiPreferensi, 4) }}) berada di bawah atau
                                    sama dengan threshold 0.30.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($hasPenilaian && $nilaiAkademik)
            <!-- Academic Performance -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-navy">Performa Akademik</h3>
                    <span class="text-sm text-gray-500">Rata-rata:
                        {{ number_format($nilaiAkademik['rata_nilai'], 1) }}</span>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    @php
                        $subjects = [
                            'n1' => 'IPA',
                            'n2' => 'IPS',
                            'n3' => 'Matematika',
                            'n4' => 'B. Indonesia',
                            'n5' => 'B. Inggris',
                            'n6' => 'Produktif',
                        ];
                    @endphp

                    @foreach ($subjects as $key => $label)
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <p class="text-xs text-gray-600 mb-1">{{ $label }}</p>
                            <p class="text-lg font-bold text-navy">{{ $nilaiAkademik['detail'][$key] }}</p>
                            <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                                <div class="bg-navy h-1.5 rounded-full"
                                    style="width: {{ $nilaiAkademik['detail'][$key] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if (!$hasPenilaian)
            <!-- No Data Notice -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-yellow-600 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    <div>
                        <h4 class="font-medium text-yellow-800 mb-1">Data Penilaian Belum Tersedia</h4>
                        <p class="text-sm text-yellow-700 mb-3">
                            Untuk mendapatkan rekomendasi jurusan, data penilaian Anda perlu diinput terlebih dahulu oleh
                            admin.
                            Silakan hubungi admin atau tunggu hingga data Anda diproses.
                        </p>
                        <p class="text-sm text-yellow-700">
                            <strong>Yang perlu diinput:</strong> Nilai akademik, minat, keahlian, dan informasi latar
                            belakang.
                        </p>
                    </div>
                </div>
            </div>
        @elseif(!$hasCalculation)
            <!-- Calculation Pending Notice -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h4 class="font-medium text-blue-800 mb-1">Menunggu Perhitungan TOPSIS</h4>
                        <p class="text-sm text-blue-700 mb-3">
                            Data penilaian Anda sudah tersedia dan siap untuk dihitung menggunakan metode TOPSIS.
                            Perhitungan akan dilakukan oleh admin untuk menghasilkan rekomendasi jurusan.
                        </p>
                        <p class="text-sm text-blue-700">
                            <strong>Status:</strong> Data lengkap, menunggu proses perhitungan.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            // Add any dashboard-specific JavaScript here
            console.log('Student Dashboard loaded');
        </script>
    @endpush
@endsection
