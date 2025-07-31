@extends('layouts.student')

@section('title', 'Detail Analisis')
@section('page-title', 'Detail Analisis TOPSIS')
@section('page-description', 'Analisis mendalam proses perhitungan rekomendasi jurusan')

@section('content')
    @if ($hasAnalysis)
        <div class="space-y-6">
            <!-- Process Overview -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-navy mb-4">Ringkasan Proses Analisis</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600 mb-1">{{ $processOverview['total_criteria'] }}</div>
                        <div class="text-sm text-gray-600">Total Kriteria</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600 mb-1">
                            {{ number_format($processOverview['preference_score'], 4) }}</div>
                        <div class="text-sm text-gray-600">Nilai Preferensi</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600 mb-1">{{ $processOverview['recommendation'] }}</div>
                        <div class="text-sm text-gray-600">Rekomendasi</div>
                    </div>
                    <div class="text-center p-4 bg-yellow-50 rounded-lg">
                        <div class="text-2xl font-bold text-yellow-600 mb-1">{{ $processOverview['threshold'] }}</div>
                        <div class="text-sm text-gray-600">Threshold</div>
                    </div>
                </div>
            </div>

            <!-- Step-by-Step Analysis -->
            <div class="space-y-4">
                @foreach ($stepAnalysis as $stepKey => $step)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <h4 class="text-lg font-semibold text-navy">{{ $step['title'] }}</h4>
                            <p class="text-sm text-gray-600 mt-1">{{ $step['description'] }}</p>
                        </div>

                        <div class="p-6">
                            @if ($stepKey === 'step1')
                                <!-- Data Collection -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h5 class="font-medium text-gray-900 mb-3">Nilai Akademik</h5>
                                        <div class="space-y-2">
                                            @foreach ($step['data']['nilai_akademik'] as $key => $nilai)
                                                @php
                                                    $labels = [
                                                        'n1' => 'IPA',
                                                        'n2' => 'IPS',
                                                        'n3' => 'Matematika',
                                                        'n4' => 'B. Indonesia',
                                                        'n5' => 'B. Inggris',
                                                        'n6' => 'Produktif',
                                                    ];
                                                @endphp
                                                <div class="flex justify-between items-center py-1">
                                                    <span class="text-sm text-gray-600">{{ $labels[$key] }}:</span>
                                                    <span class="font-medium">{{ $nilai }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="font-medium text-gray-900 mb-3">Data Lainnya</h5>
                                        <div class="space-y-2">
                                            <div class="text-sm">
                                                <span class="text-gray-600">Minat A:</span>
                                                {{ $step['data']['minat']['ma'] }}
                                            </div>
                                            <div class="text-sm">
                                                <span class="text-gray-600">Minat B:</span>
                                                {{ $step['data']['minat']['mb'] }}
                                            </div>
                                            <div class="text-sm">
                                                <span class="text-gray-600">Minat C:</span>
                                                {{ $step['data']['minat']['mc'] }}
                                            </div>
                                            <div class="text-sm">
                                                <span class="text-gray-600">Minat D:</span>
                                                {{ $step['data']['minat']['md'] }}
                                            </div>
                                            <div class="text-sm">
                                                <span class="text-gray-600">Keahlian:</span>
                                                {{ $step['data']['keahlian'] }}
                                            </div>
                                            <div class="text-sm">
                                                <span class="text-gray-600">Penghasilan Ortu:</span>
                                                {{ $step['data']['penghasilan_ortu'] }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($stepKey === 'step2')
                                <!-- Data Conversion -->
                                <div class="overflow-x-auto">
                                    <table class="min-w-full">
                                        <thead>
                                            <tr class="border-b border-gray-200">
                                                <th class="text-left py-2 text-sm font-medium text-gray-700">Kriteria</th>
                                                <th class="text-left py-2 text-sm font-medium text-gray-700">Data Asli</th>
                                                <th class="text-left py-2 text-sm font-medium text-gray-700">Nilai Numerik
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="border-b border-gray-100">
                                                <td class="py-2 text-sm">Minat A</td>
                                                <td class="py-2 text-sm text-gray-600">
                                                    {{ $step['data']['minat']['ma'] ?? '' }}</td>
                                                <td class="py-2 text-sm font-medium">{{ $step['conversions']['minat_a'] }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-100">
                                                <td class="py-2 text-sm">Minat B</td>
                                                <td class="py-2 text-sm text-gray-600">
                                                    {{ $step['data']['minat']['mb'] ?? '' }}</td>
                                                <td class="py-2 text-sm font-medium">{{ $step['conversions']['minat_b'] }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-100">
                                                <td class="py-2 text-sm">Minat C</td>
                                                <td class="py-2 text-sm text-gray-600">
                                                    {{ $step['data']['minat']['mc'] ?? '' }}</td>
                                                <td class="py-2 text-sm font-medium">{{ $step['conversions']['minat_c'] }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-100">
                                                <td class="py-2 text-sm">Minat D</td>
                                                <td class="py-2 text-sm text-gray-600">
                                                    {{ $step['data']['minat']['md'] ?? '' }}</td>
                                                <td class="py-2 text-sm font-medium">{{ $step['conversions']['minat_d'] }}
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-100">
                                                <td class="py-2 text-sm">Keahlian</td>
                                                <td class="py-2 text-sm text-gray-600">
                                                    {{ $step['data']['keahlian'] ?? '' }}</td>
                                                <td class="py-2 text-sm font-medium">{{ $step['conversions']['keahlian'] }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 text-sm">Penghasilan</td>
                                                <td class="py-2 text-sm text-gray-600">
                                                    {{ $step['data']['penghasilan_ortu'] ?? '' }}</td>
                                                <td class="py-2 text-sm font-medium">
                                                    {{ $step['conversions']['penghasilan'] }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @elseif($stepKey === 'step3')
                                <!-- Normalization -->
                                <div>
                                    <p class="text-sm text-gray-600 mb-4">{{ $step['description'] }}</p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                        @php
                                            $criteriaLabels = [
                                                'n1' => 'IPA',
                                                'n2' => 'IPS',
                                                'n3' => 'MTK',
                                                'n4' => 'B.IND',
                                                'n5' => 'B.ING',
                                                'n6' => 'PROD',
                                                'ma' => 'Minat A',
                                                'mb' => 'Minat B',
                                                'mc' => 'Minat C',
                                                'md' => 'Minat D',
                                                'bb' => 'Keahlian',
                                                'bp' => 'Penghasilan',
                                            ];
                                        @endphp
                                        @foreach ($step['normalized_values'] as $key => $value)
                                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                                <div class="text-xs text-gray-600 mb-1">{{ $criteriaLabels[$key] ?? $key }}
                                                </div>
                                                <div class="text-sm font-medium">{{ number_format($value, 6) }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @elseif($stepKey === 'step4')
                                <!-- Weighting -->
                                <div>
                                    <p class="text-sm text-gray-600 mb-4">{{ $step['description'] }}</p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                        @foreach ($step['weighted_values'] as $key => $value)
                                            <div class="text-center p-3 bg-blue-50 rounded-lg">
                                                <div class="text-xs text-gray-600 mb-1">{{ $criteriaLabels[$key] ?? $key }}
                                                </div>
                                                <div class="text-sm font-medium">{{ number_format($value, 6) }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @elseif($stepKey === 'step5')
                                <!-- Ideal Solutions -->
                                <div>
                                    <p class="text-sm text-gray-600 mb-4">{{ $step['description'] }}</p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="p-4 bg-green-50 rounded-lg">
                                            <h5 class="font-medium text-green-800 mb-2">Jarak ke Solusi Ideal Positif (D⁺)
                                            </h5>
                                            <div class="text-2xl font-bold text-green-600">
                                                {{ number_format($step['distances']['positive'], 6) }}</div>
                                        </div>
                                        <div class="p-4 bg-red-50 rounded-lg">
                                            <h5 class="font-medium text-red-800 mb-2">Jarak ke Solusi Ideal Negatif (D⁻)
                                            </h5>
                                            <div class="text-2xl font-bold text-red-600">
                                                {{ number_format($step['distances']['negative'], 6) }}</div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($stepKey === 'step6')
                                <!-- Final Result -->
                                <div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="p-4 bg-navy-50 rounded-lg">
                                            <h5 class="font-medium text-navy mb-2">Nilai Preferensi</h5>
                                            <div class="text-3xl font-bold text-navy mb-2">
                                                {{ number_format($step['result']['preference_score'], 4) }}</div>
                                            <p class="text-sm text-gray-600">{{ $step['result']['explanation'] }}</p>
                                        </div>
                                        <div
                                            class="p-4 bg-{{ $step['result']['recommendation'] === 'TKJ' ? 'blue' : 'green' }}-50 rounded-lg">
                                            <h5
                                                class="font-medium text-{{ $step['result']['recommendation'] === 'TKJ' ? 'blue' : 'green' }}-800 mb-2">
                                                Rekomendasi Akhir</h5>
                                            <div
                                                class="text-3xl font-bold text-{{ $step['result']['recommendation'] === 'TKJ' ? 'blue' : 'green' }}-600 mb-2">
                                                {{ $step['result']['recommendation'] }}
                                            </div>
                                            <p class="text-sm text-gray-600">
                                                {{ $step['result']['recommendation'] === 'TKJ' ? 'Teknik Komputer dan Jaringan' : 'Teknik Kendaraan Ringan' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Navigation Links -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('student.analisis.topsis') }}"
                    class="flex-1 bg-navy text-white px-6 py-3 rounded-lg hover:bg-navy-dark transition duration-200 text-center font-medium">
                    Lihat Perhitungan Lengkap
                </a>
                <a href="{{ route('student.analisis.kriteria') }}"
                    class="flex-1 bg-white border border-navy text-navy px-6 py-3 rounded-lg hover:bg-navy hover:text-white transition duration-200 text-center font-medium">
                    Detail Kriteria
                </a>
                <a href="{{ route('student.rekomendasi.index') }}"
                    class="flex-1 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-200 text-center font-medium">
                    Kembali ke Rekomendasi
                </a>
            </div>
        </div>
    @else
        <!-- No Analysis Available -->
        <div class="min-h-96 flex items-center justify-center">
            <div class="text-center max-w-md mx-auto">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 00-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Belum Ada Data Analisis</h3>
                <p class="text-gray-600 mb-6">
                    Analisis TOPSIS belum tersedia. Data penilaian dan perhitungan perlu diselesaikan terlebih dahulu.
                </p>
                <div class="space-y-3">
                    <p class="text-sm text-gray-500">
                        <strong>Proses yang diperlukan:</strong> Input data penilaian → Perhitungan TOPSIS → Analisis
                        tersedia
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
