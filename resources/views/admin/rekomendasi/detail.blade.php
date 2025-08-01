@extends('layouts.admin')

@section('title', 'Detail Rekomendasi')
@section('page-title', 'Detail Rekomendasi Jurusan')
@section('page-description', $perhitungan->pesertaDidik->nama_lengkap . ' - ' . $perhitungan->rekomendasi_lengkap)

@section('content')
    <div class="space-y-6">
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.rekomendasi.index') }}"
                    class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-lg font-semibold text-navy">{{ $perhitungan->pesertaDidik->nama_lengkap }}</h2>
                    <p class="text-sm text-gray-600">NISN: {{ $perhitungan->pesertaDidik->nisn }} • Ranking:
                        {{ $ranking }} dari {{ $totalStudents }}</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.perhitungan.detail', $perhitungan->pesertaDidik) }}"
                    class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Lihat Detail Perhitungan
                </a>
            </div>
        </div>

        <!-- Main Recommendation Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div
                class="px-6 py-4 bg-gradient-to-r {{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'from-blue-600 to-blue-700' : 'from-green-600 to-green-700' }}">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg">
                            <span
                                class="text-2xl font-bold {{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'text-blue-600' : 'text-green-600' }}">
                                {{ $perhitungan->jurusan_rekomendasi }}
                            </span>
                        </div>
                        <div class="text-white">
                            <h3 class="text-xl font-bold">{{ $perhitungan->rekomendasi_lengkap }}</h3>
                            <p class="opacity-90">{{ $perhitungan->pesertaDidik->nama_lengkap }}</p>
                        </div>
                    </div>
                    <div class="text-right text-white">
                        <p class="text-sm opacity-90">Nilai Preferensi</p>
                        <p class="text-3xl font-bold">{{ number_format($perhitungan->nilai_preferensi, 4) }}</p>
                        <p class="text-sm opacity-75">{{ number_format($perhitungan->nilai_preferensi * 100, 2) }}%</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Performance Metrics -->
                    <div class="lg:col-span-1">
                        <h4 class="text-lg font-semibold text-navy mb-4">Metrik Performa</h4>

                        <div class="space-y-4">
                            <!-- Ranking -->
                            <div class="bg-gold-50 p-4 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gold-dark font-medium">Ranking</p>
                                        <p class="text-2xl font-bold text-gold-dark">{{ $ranking }}</p>
                                    </div>
                                    <div class="w-12 h-12 bg-gold rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-xs text-gold-dark mt-2">dari {{ $totalStudents }} siswa</p>
                            </div>

                            <!-- Distance Metrics -->
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <p class="text-sm text-blue-800 font-medium mb-2">Jarak ke Solusi Positif</p>
                                <p class="text-xl font-bold text-blue-600">
                                    {{ number_format($perhitungan->jarak_positif, 6) }}</p>
                            </div>

                            <div class="bg-purple-50 p-4 rounded-lg">
                                <p class="text-sm text-purple-800 font-medium mb-2">Jarak ke Solusi Negatif</p>
                                <p class="text-xl font-bold text-purple-600">
                                    {{ number_format($perhitungan->jarak_negatif, 6) }}</p>
                            </div>

                            <!-- TOPSIS Score -->
                            <div class="bg-green-50 p-4 rounded-lg">
                                <p class="text-sm text-green-800 font-medium mb-2">Skor TOPSIS</p>
                                <div class="flex items-center space-x-2">
                                    <div class="flex-1 bg-gray-200 rounded-full h-3">
                                        <div class="bg-green-500 h-3 rounded-full"
                                            style="width: {{ $perhitungan->nilai_preferensi * 100 }}%"></div>
                                    </div>
                                    <span
                                        class="text-sm font-bold text-green-600">{{ number_format($perhitungan->nilai_preferensi * 100, 1) }}%</span>
                                </div>
                                <p class="text-xs text-green-700 mt-2">
                                    {{ $perhitungan->nilai_preferensi > 0.3 ? 'Di atas threshold (0.30)' : 'Di bawah threshold (0.30)' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Student Data -->
                    <div class="lg:col-span-2">
                        <h4 class="text-lg font-semibold text-navy mb-4">Data Peserta Didik</h4>

                        @if ($perhitungan->penilaian)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Academic Scores -->
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <h5 class="font-semibold text-blue-800 mb-3">Nilai Akademik</h5>
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-blue-700">IPA</span>
                                            <div class="flex items-center space-x-2">
                                                <div class="w-16 bg-blue-200 rounded-full h-2">
                                                    <div class="bg-blue-500 h-2 rounded-full"
                                                        style="width: {{ $perhitungan->penilaian->nilai_ipa }}%"></div>
                                                </div>
                                                <span
                                                    class="text-sm font-semibold text-blue-800 w-8">{{ $perhitungan->penilaian->nilai_ipa }}</span>
                                            </div>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-blue-700">IPS</span>
                                            <div class="flex items-center space-x-2">
                                                <div class="w-16 bg-blue-200 rounded-full h-2">
                                                    <div class="bg-blue-500 h-2 rounded-full"
                                                        style="width: {{ $perhitungan->penilaian->nilai_ips }}%"></div>
                                                </div>
                                                <span
                                                    class="text-sm font-semibold text-blue-800 w-8">{{ $perhitungan->penilaian->nilai_ips }}</span>
                                            </div>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-blue-700">Matematika</span>
                                            <div class="flex items-center space-x-2">
                                                <div class="w-16 bg-blue-200 rounded-full h-2">
                                                    <div class="bg-blue-500 h-2 rounded-full"
                                                        style="width: {{ $perhitungan->penilaian->nilai_matematika }}%">
                                                    </div>
                                                </div>
                                                <span
                                                    class="text-sm font-semibold text-blue-800 w-8">{{ $perhitungan->penilaian->nilai_matematika }}</span>
                                            </div>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-blue-700">B. Indonesia</span>
                                            <div class="flex items-center space-x-2">
                                                <div class="w-16 bg-blue-200 rounded-full h-2">
                                                    <div class="bg-blue-500 h-2 rounded-full"
                                                        style="width: {{ $perhitungan->penilaian->nilai_bahasa_indonesia }}%">
                                                    </div>
                                                </div>
                                                <span
                                                    class="text-sm font-semibold text-blue-800 w-8">{{ $perhitungan->penilaian->nilai_bahasa_indonesia }}</span>
                                            </div>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-blue-700">B. Inggris</span>
                                            <div class="flex items-center space-x-2">
                                                <div class="w-16 bg-blue-200 rounded-full h-2">
                                                    <div class="bg-blue-500 h-2 rounded-full"
                                                        style="width: {{ $perhitungan->penilaian->nilai_bahasa_inggris }}%">
                                                    </div>
                                                </div>
                                                <span
                                                    class="text-sm font-semibold text-blue-800 w-8">{{ $perhitungan->penilaian->nilai_bahasa_inggris }}</span>
                                            </div>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-blue-700">Produktif</span>
                                            <div class="flex items-center space-x-2">
                                                <div class="w-16 bg-blue-200 rounded-full h-2">
                                                    <div class="bg-blue-500 h-2 rounded-full"
                                                        style="width: {{ $perhitungan->penilaian->nilai_produktif }}%">
                                                    </div>
                                                </div>
                                                <span
                                                    class="text-sm font-semibold text-blue-800 w-8">{{ $perhitungan->penilaian->nilai_produktif }}</span>
                                            </div>
                                        </div>
                                        <div class="pt-2 border-t border-blue-200">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-semibold text-blue-800">Rata-rata</span>
                                                <span
                                                    class="text-lg font-bold text-blue-800">{{ number_format($perhitungan->penilaian->rata_nilai_akademik, 1) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Interest & Skills -->
                                <div class="space-y-4">
                                    <!-- Interests -->
                                    <div class="bg-green-50 p-4 rounded-lg">
                                        <h5 class="font-semibold text-green-800 mb-3">Minat</h5>
                                        <div class="space-y-2 text-sm">
                                            <div class="flex justify-between">
                                                <span class="text-green-700">Minat A:</span>
                                                <span
                                                    class="font-medium text-green-800">{{ $perhitungan->penilaian->minat_a }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-green-700">Minat B:</span>
                                                <span
                                                    class="font-medium text-green-800">{{ $perhitungan->penilaian->minat_b }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-green-700">Minat C:</span>
                                                <span
                                                    class="font-medium text-green-800">{{ $perhitungan->penilaian->minat_c }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-green-700">Minat D:</span>
                                                <span
                                                    class="font-medium text-green-800">{{ $perhitungan->penilaian->minat_d }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Skills & Background -->
                                    <div class="bg-purple-50 p-4 rounded-lg">
                                        <h5 class="font-semibold text-purple-800 mb-3">Keahlian & Latar Belakang</h5>
                                        <div class="space-y-2 text-sm">
                                            <div class="flex justify-between">
                                                <span class="text-purple-700">Keahlian:</span>
                                                <span
                                                    class="font-medium text-purple-800">{{ $perhitungan->penilaian->keahlian }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-purple-700">Penghasilan Ortu:</span>
                                                <span
                                                    class="font-medium text-purple-800">{{ $perhitungan->penilaian->penghasilan_ortu }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-gray-500">Data penilaian tidak ditemukan</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Comparison with Similar Students -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-navy mb-6">Perbandingan dengan Siswa Lain</h3>

            @if ($similarStudents->count() > 0)
                <div class="space-y-4">
                    <p class="text-sm text-gray-600 mb-4">
                        Siswa dengan nilai preferensi serupa (± 0.1 dari
                        {{ number_format($perhitungan->nilai_preferensi, 4) }})
                    </p>

                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        NISN</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nilai Preferensi</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Rekomendasi</th>
                                    <th
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Selisih</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($similarStudents as $student)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 text-sm font-medium text-gray-900">
                                            {{ $student->pesertaDidik->nama_lengkap }}
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-500">
                                            {{ $student->pesertaDidik->nisn }}
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-900">
                                            {{ number_format($student->nilai_preferensi, 4) }}
                                        </td>
                                        <td class="px-4 py-2">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $student->jurusan_rekomendasi === 'TKJ' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                                {{ $student->jurusan_rekomendasi }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 text-sm">
                                            @php
                                                $diff = $student->nilai_preferensi - $perhitungan->nilai_preferensi;
                                                $color =
                                                    $diff > 0
                                                        ? 'text-green-600'
                                                        : ($diff < 0
                                                            ? 'text-red-600'
                                                            : 'text-gray-600');
                                                $sign = $diff > 0 ? '+' : '';
                                            @endphp
                                            <span class="{{ $color }}">
                                                {{ $sign }}{{ number_format($diff, 4) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 00-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <p class="text-gray-500">Tidak ada siswa dengan nilai preferensi serupa</p>
                </div>
            @endif
        </div>

        <!-- Recommendation Analysis -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-navy mb-6">Analisis Rekomendasi</h3>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Why This Recommendation -->
                <div class="bg-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-50 p-6 rounded-lg">
                    <h4
                        class="font-semibold text-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Mengapa {{ $perhitungan->jurusan_rekomendasi }}?
                    </h4>
                    <div
                        class="text-sm text-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-700 space-y-2">
                        @if ($perhitungan->jurusan_rekomendasi === 'TKJ')
                            <p>• Nilai preferensi {{ number_format($perhitungan->nilai_preferensi, 4) }} > 0.30 (threshold
                                TKJ)</p>
                            <p>• Menunjukkan kesesuaian yang baik dengan bidang teknologi informasi</p>
                            <p>• Cocok untuk siswa dengan minat tinggi pada komputer dan jaringan</p>
                        @else
                            <p>• Nilai preferensi {{ number_format($perhitungan->nilai_preferensi, 4) }} ≤ 0.30 (threshold
                                TKR)</p>
                            <p>• Menunjukkan kesesuaian yang baik dengan bidang otomotif</p>
                            <p>• Cocok untuk siswa dengan minat pada teknologi mekanik</p>
                        @endif
                        <p>• Ranking {{ $ranking }} dari {{ $totalStudents }} siswa dalam tahun ajaran ini</p>
                    </div>
                </div>

                <!-- Career Prospects -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6" />
                        </svg>
                        Prospek Karir
                    </h4>
                    <div class="text-sm text-gray-700 space-y-2">
                        @if ($perhitungan->jurusan_rekomendasi === 'TKJ')
                            <p>• Network Administrator</p>
                            <p>• System Administrator</p>
                            <p>• Web Developer</p>
                            <p>• IT Support Specialist</p>
                            <p>• Database Administrator</p>
                            <p>• Cyber Security Analyst</p>
                        @else
                            <p>• Mekanik Otomotif</p>
                            <p>• Teknisi Kendaraan</p>
                            <p>• Quality Control Automotive</p>
                            <p>• Supervisor Bengkel</p>
                            <p>• Konsultan Otomotif</p>
                            <p>• Wirausaha Bengkel</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('admin.perhitungan.detail', $perhitungan->pesertaDidik) }}"
                class="flex-1 bg-navy text-white px-6 py-3 rounded-lg hover:bg-navy-dark transition duration-200 text-center font-medium">
                Lihat Detail Perhitungan TOPSIS
            </a>
            <a href="{{ route('admin.peserta-didik.show', $perhitungan->pesertaDidik) }}"
                class="flex-1 bg-white border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition duration-200 text-center font-medium">
                Lihat Data Peserta Didik
            </a>
            <a href="{{ route('admin.rekomendasi.export', ['format' => 'pdf', 'siswa_id' => $perhitungan->pesertaDidik->peserta_didik_id]) }}"
                class="flex-1 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-200 text-center font-medium">
                Export PDF
            </a>
        </div>
    </div>

    @push('scripts')
        <script>
            // Add any specific JavaScript for the recommendation detail page
            console.log('Recommendation detail loaded for:', '{{ $perhitungan->pesertaDidik->nama_lengkap }}');
        </script>
    @endpush

@endsection
