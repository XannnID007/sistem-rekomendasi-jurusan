@extends('layouts.admin')

@section('title', 'Detail Perhitungan TOPSIS')
@section('page-title', 'Detail Perhitungan TOPSIS')
@section('page-description', $perhitungan->pesertaDidik->nama_lengkap . ' - ' . $perhitungan->pesertaDidik->nisn)

@section('content')
    <div class="space-y-6">
        <!-- Header Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-start justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-navy rounded-xl flex items-center justify-center">
                        <span
                            class="text-white font-bold text-xl">{{ substr($perhitungan->pesertaDidik->nama_lengkap, 0, 1) }}</span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-navy">{{ $perhitungan->pesertaDidik->nama_lengkap }}</h1>
                        <p class="text-gray-600">NISN: {{ $perhitungan->pesertaDidik->nisn }}</p>
                        <p class="text-sm text-gray-500">{{ $perhitungan->pesertaDidik->jenis_kelamin_lengkap }} •
                            {{ $perhitungan->tahun_ajaran }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="flex items-center space-x-4">
                        <div class="text-center">
                            <div class="text-sm text-gray-500">Ranking</div>
                            <div class="text-2xl font-bold text-navy">{{ $ranking }}</div>
                            <div class="text-xs text-gray-400">dari {{ $totalStudents }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-sm text-gray-500">Nilai Preferensi</div>
                            <div class="text-2xl font-bold text-navy">{{ number_format($perhitungan->nilai_preferensi, 4) }}
                            </div>
                            <div class="text-xs text-gray-400">{{ number_format($perhitungan->nilai_preferensi * 100, 2) }}%
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-sm text-gray-500">Rekomendasi</div>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ $perhitungan->rekomendasi_lengkap }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TOPSIS Steps -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Step 1: Raw Data -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-navy mb-4 flex items-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                        <span class="text-blue-600 font-bold text-sm">1</span>
                    </div>
                    Data Penilaian
                </h3>

                <div class="space-y-4">
                    <!-- Nilai Akademik -->
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">Nilai Akademik</h4>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">IPA:</span>
                                <span class="font-medium">{{ $perhitungan->penilaian->nilai_ipa }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">IPS:</span>
                                <span class="font-medium">{{ $perhitungan->penilaian->nilai_ips }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Matematika:</span>
                                <span class="font-medium">{{ $perhitungan->penilaian->nilai_matematika }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">B. Indonesia:</span>
                                <span class="font-medium">{{ $perhitungan->penilaian->nilai_bahasa_indonesia }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">B. Inggris:</span>
                                <span class="font-medium">{{ $perhitungan->penilaian->nilai_bahasa_inggris }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">PKN:</span>
                                <span class="font-medium">{{ $perhitungan->penilaian->nilai_pkn }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Minat -->
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">Minat</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Minat A:</span>
                                <span class="font-medium">{{ $perhitungan->penilaian->minat_a }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Minat B:</span>
                                <span class="font-medium">{{ $perhitungan->penilaian->minat_b }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Minat C:</span>
                                <span class="font-medium">{{ $perhitungan->penilaian->minat_c }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Minat D:</span>
                                <span class="font-medium">{{ $perhitungan->penilaian->minat_d }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Keahlian & Background -->
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">Lainnya</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Keahlian:</span>
                                <span class="font-medium">{{ $perhitungan->penilaian->keahlian }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Biaya Gelombang:</span>
                                <span class="font-medium">{{ $perhitungan->penilaian->biaya_gelombang }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Normalized Values -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-navy mb-4 flex items-center">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <span class="text-green-600 font-bold text-sm">2</span>
                    </div>
                    Nilai Ternormalisasi
                </h3>

                <div class="space-y-3">
                    @foreach ($kriteria as $k)
                        @php
                            $normalizedField = 'normalized_' . strtolower($k->kode_kriteria);
                            $normalizedValue = $perhitungan->$normalizedField ?? 0;
                        @endphp
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">{{ $k->kode_kriteria }} ({{ $k->nama_kriteria }}):</span>
                            <span class="font-medium">{{ number_format($normalizedValue, 6) }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                    <p class="text-xs text-blue-700">
                        <strong>Proses:</strong> Setiap nilai dibagi dengan akar kuadrat dari jumlah kuadrat semua nilai
                        pada kriteria yang sama.
                    </p>
                </div>
            </div>

            <!-- Step 3: Weighted Values -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-navy mb-4 flex items-center">
                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                        <span class="text-purple-600 font-bold text-sm">3</span>
                    </div>
                    Nilai Terbobot
                </h3>

                <div class="space-y-3">
                    @foreach ($kriteria as $k)
                        @php
                            $weightedField = 'weighted_' . strtolower($k->kode_kriteria);
                            $weightedValue = $perhitungan->$weightedField ?? 0;
                        @endphp
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">{{ $k->kode_kriteria }} ({{ $k->bobot_persen }}):</span>
                            <span class="font-medium">{{ number_format($weightedValue, 6) }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 p-3 bg-purple-50 rounded-lg">
                    <p class="text-xs text-purple-700">
                        <strong>Proses:</strong> Nilai ternormalisasi dikalikan dengan bobot masing-masing kriteria.
                    </p>
                </div>
            </div>

            <!-- Step 4: Distance & Preference Score -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-navy mb-4 flex items-center">
                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                        <span class="text-yellow-600 font-bold text-sm">4</span>
                    </div>
                    Jarak & Preferensi
                </h3>

                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-4 bg-red-50 rounded-lg">
                            <div class="text-sm text-gray-600 mb-1">Jarak ke Solusi Ideal Positif</div>
                            <div class="text-lg font-bold text-red-600">{{ number_format($perhitungan->jarak_positif, 6) }}
                            </div>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <div class="text-sm text-gray-600 mb-1">Jarak ke Solusi Ideal Negatif</div>
                            <div class="text-lg font-bold text-green-600">
                                {{ number_format($perhitungan->jarak_negatif, 6) }}</div>
                        </div>
                    </div>

                    <div class="text-center p-4 bg-navy bg-opacity-10 rounded-lg border-2 border-navy border-opacity-20">
                        <div class="text-sm text-gray-600 mb-1">Nilai Preferensi</div>
                        <div class="text-2xl font-bold text-navy">{{ number_format($perhitungan->nilai_preferensi, 6) }}
                        </div>
                        <div class="text-sm text-gray-500 mt-1">
                            Formula: D⁻ / (D⁺ + D⁻)
                        </div>
                    </div>

                    <div class="p-3 bg-yellow-50 rounded-lg">
                        <p class="text-xs text-yellow-700">
                            <strong>Rekomendasi:</strong>
                            @if ($perhitungan->nilai_preferensi > 0.3)
                                Nilai preferensi > 0.30, direkomendasikan <strong>TKJ</strong>
                            @else
                                Nilai preferensi ≤ 0.30, direkomendasikan <strong>TKR</strong>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Decision Matrix (Optional - untuk perbandingan) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-navy mb-4">Matriks Keputusan ({{ $perhitungan->tahun_ajaran }})</h3>

            <div class="overflow-x-auto">
                <table class="min-w-full text-xs">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-2 py-2 text-left font-medium text-gray-500">Siswa</th>
                            @foreach ($kriteria as $k)
                                <th class="px-2 py-2 text-center font-medium text-gray-500">{{ $k->kode_kriteria }}</th>
                            @endforeach
                            <th class="px-2 py-2 text-center font-medium text-gray-500">Preferensi</th>
                            <th class="px-2 py-2 text-center font-medium text-gray-500">Rekomendasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($allPerhitungan->take(10) as $calc)
                            <tr
                                class="{{ $calc->perhitungan_id === $perhitungan->perhitungan_id ? 'bg-blue-50 font-semibold' : 'hover:bg-gray-50' }}">
                                <td class="px-2 py-2 text-left">
                                    {{ Str::limit($calc->pesertaDidik->nama_lengkap, 20) }}
                                    @if ($calc->perhitungan_id === $perhitungan->perhitungan_id)
                                        <span class="text-blue-600">(Anda)</span>
                                    @endif
                                </td>
                                @foreach ($kriteria as $k)
                                    @php
                                        $weightedField = 'weighted_' . strtolower($k->kode_kriteria);
                                        $value = $calc->$weightedField ?? 0;
                                    @endphp
                                    <td class="px-2 py-2 text-center">{{ number_format($value, 4) }}</td>
                                @endforeach
                                <td class="px-2 py-2 text-center font-medium">
                                    {{ number_format($calc->nilai_preferensi, 4) }}</td>
                                <td class="px-2 py-2 text-center">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $calc->jurusan_rekomendasi === 'TKJ' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $calc->jurusan_rekomendasi }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($allPerhitungan->count() > 10)
                <div class="mt-4 text-center text-sm text-gray-500">
                    Menampilkan 10 dari {{ $allPerhitungan->count() }} total perhitungan
                </div>
            @endif
        </div>

        <!-- Actions -->
        <div class="flex justify-between">
            <a href="{{ route('admin.perhitungan.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>

    @push('styles')
        <style>
            @media print {
                .no-print {
                    display: none !important;
                }

                body {
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }
            }
        </style>
    @endpush
@endsection
