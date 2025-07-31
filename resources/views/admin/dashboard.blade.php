@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('page-description', 'Selamat datang di panel admin SPK Pemilihan Jurusan')

@section('content')
    <div class="space-y-6">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Peserta Didik -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Peserta Didik</p>
                        <p class="text-3xl font-bold text-navy">{{ $totalPesertaDidik }}</p>
                        <p class="text-sm text-green-600 mt-1">
                            <span class="font-medium">Tahun {{ $currentYear }}</span>
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Penilaian -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Data Penilaian</p>
                        <p class="text-3xl font-bold text-navy">{{ $totalPenilaian }}</p>
                        <p class="text-sm text-blue-600 mt-1">
                            <span class="font-medium">Sudah diinput</span>
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Perhitungan -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Perhitungan TOPSIS</p>
                        <p class="text-3xl font-bold text-navy">{{ $totalPerhitungan }}</p>
                        <p class="text-sm text-purple-600 mt-1">
                            <span class="font-medium">Sudah dihitung</span>
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Rata-rata Preferensi -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Rata-rata Preferensi</p>
                        <p class="text-3xl font-bold text-navy">
                            {{ number_format($statistics['average_preference_score'] ?? 0, 3) }}</p>
                        <p class="text-sm text-gold-dark mt-1">
                            <span class="font-medium">Skor TOPSIS</span>
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-50 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recommendation Distribution Chart -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-navy">Distribusi Rekomendasi Jurusan</h3>
                    <div class="text-sm text-gray-500">{{ $currentYear }}</div>
                </div>

                <div class="space-y-4">
                    <!-- TKJ Bar -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 bg-blue-500 rounded"></div>
                            <span class="text-sm font-medium text-gray-700">TKJ (Teknik Komputer & Jaringan)</span>
                        </div>
                        <span class="text-sm font-bold text-navy">{{ $tkjCount }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-blue-500 h-3 rounded-full"
                            style="width: {{ $totalPerhitungan > 0 ? ($tkjCount / $totalPerhitungan) * 100 : 0 }}%"></div>
                    </div>

                    <!-- TKR Bar -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 bg-green-500 rounded"></div>
                            <span class="text-sm font-medium text-gray-700">TKR (Teknik Kendaraan Ringan)</span>
                        </div>
                        <span class="text-sm font-bold text-navy">{{ $tkrCount }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-green-500 h-3 rounded-full"
                            style="width: {{ $totalPerhitungan > 0 ? ($tkrCount / $totalPerhitungan) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <!-- Summary -->
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <div class="grid grid-cols-2 gap-4 text-center">
                        <div>
                            <p class="text-2xl font-bold text-blue-600">
                                {{ $totalPerhitungan > 0 ? number_format(($tkjCount / $totalPerhitungan) * 100, 1) : 0 }}%
                            </p>
                            <p class="text-sm text-gray-600">Rekomendasi TKJ</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-green-600">
                                {{ $totalPerhitungan > 0 ? number_format(($tkrCount / $totalPerhitungan) * 100, 1) : 0 }}%
                            </p>
                            <p class="text-sm text-gray-600">Rekomendasi TKR</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Calculations -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-navy">Perhitungan Terbaru</h3>
                    <a href="{{ route('admin.perhitungan.index') }}"
                        class="text-sm text-navy hover:text-navy-dark font-medium">
                        Lihat Semua →
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($recentCalculations as $calculation)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">{{ $calculation->pesertaDidik->nama_lengkap }}</p>
                                <p class="text-sm text-gray-600">NISN: {{ $calculation->pesertaDidik->nisn }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $calculation->tanggal_perhitungan->format('d M Y, H:i') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $calculation->jurusan_rekomendasi === 'TKJ' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $calculation->jurusan_rekomendasi }}
                                </span>
                                <p class="text-sm font-medium text-gray-900 mt-1">
                                    {{ number_format($calculation->nilai_preferensi, 3) }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">Belum ada perhitungan</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Action Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Tambah Peserta Didik -->
            <a href="{{ route('admin.peserta-didik.create') }}"
                class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">Tambah Peserta Didik</h3>
                        <p class="text-sm text-gray-500">Daftarkan siswa baru</p>
                    </div>
                </div>
            </a>

            <!-- Hitung TOPSIS -->
            <a href="{{ route('admin.perhitungan.create') }}"
                class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">Hitung TOPSIS</h3>
                        <p class="text-sm text-gray-500">Jalankan perhitungan</p>
                    </div>
                </div>
            </a>

            <!-- Lihat Rekomendasi -->
            <a href="{{ route('admin.rekomendasi.index') }}"
                class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 00-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">Hasil Rekomendasi</h3>
                        <p class="text-sm text-gray-500">Lihat semua hasil</p>
                    </div>
                </div>
            </a>

            <!-- Cetak Laporan -->
            <a href="{{ route('admin.laporan.index') }}"
                class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">Cetak Laporan</h3>
                        <p class="text-sm text-gray-500">Generate laporan</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- System Information -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-navy mb-4">Informasi Sistem</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <p class="text-sm text-gray-600">Metode Perhitungan</p>
                    <p class="text-lg font-bold text-navy">TOPSIS</p>
                    <p class="text-xs text-gray-500">Technique for Order Preference by Similarity to Ideal Solution</p>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-600">Total Kriteria</p>
                    <p class="text-lg font-bold text-navy">12 Kriteria</p>
                    <p class="text-xs text-gray-500">6 Nilai Akademik + 4 Minat + 1 Keahlian + 1 Ekonomi</p>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-600">Threshold</p>
                    <p class="text-lg font-bold text-navy">0.30</p>
                    <p class="text-xs text-gray-500">> 0.30 = TKJ, ≤ 0.30 = TKR</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Add any dashboard-specific JavaScript here
        console.log('Admin Dashboard loaded');
    </script>
@endpush
