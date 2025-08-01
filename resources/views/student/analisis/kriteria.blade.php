@extends('layouts.student')

@section('title', 'Detail Kriteria')
@section('page-title', 'Detail Kriteria Penilaian')
@section('page-description', 'Penjelasan kriteria yang digunakan dalam metode TOPSIS')

@section('content')
    <div class="space-y-6">
        <!-- Overview Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-navy">Kriteria Penilaian TOPSIS</h3>
                <div class="text-sm text-gray-500">Total Bobot: {{ number_format($kriteria->sum('bobot'), 2) }}</div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600 mb-1">{{ $kriteriaGrouped['Nilai Akademik']->count() }}
                    </div>
                    <div class="text-sm text-gray-600">Kriteria Akademik</div>
                    <div class="text-xs text-gray-500 mt-1">
                        Bobot: {{ number_format($kriteriaGrouped['Nilai Akademik']->sum('bobot') * 100, 1) }}%
                    </div>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <div class="text-2xl font-bold text-green-600 mb-1">{{ $kriteriaGrouped['Minat']->count() }}</div>
                    <div class="text-sm text-gray-600">Kriteria Minat</div>
                    <div class="text-xs text-gray-500 mt-1">
                        Bobot: {{ number_format($kriteriaGrouped['Minat']->sum('bobot') * 100, 1) }}%
                    </div>
                </div>
                <div class="text-center p-4 bg-purple-50 rounded-lg">
                    <div class="text-2xl font-bold text-purple-600 mb-1">{{ $kriteriaGrouped['Lainnya']->count() }}</div>
                    <div class="text-sm text-gray-600">Kriteria Lainnya</div>
                    <div class="text-xs text-gray-500 mt-1">
                        Bobot: {{ number_format($kriteriaGrouped['Lainnya']->sum('bobot') * 100, 1) }}%
                    </div>
                </div>
            </div>

            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h4 class="font-medium text-yellow-800 mb-1">Tentang Kriteria</h4>
                        <p class="text-sm text-yellow-700">
                            Setiap kriteria memiliki bobot yang berbeda sesuai tingkat kepentingannya dalam menentukan
                            rekomendasi jurusan.
                            Semua kriteria bersifat "benefit" yang artinya semakin tinggi nilainya, semakin baik.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kriteria Groups -->
        @foreach ($kriteriaGrouped as $groupName => $groupKriteria)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-navy">{{ $groupName }}</h3>
                    <span class="text-sm text-gray-500">
                        Total Bobot: {{ number_format($groupKriteria->sum('bobot') * 100, 1) }}%
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Kode</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Nama Kriteria</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Bobot</th>
                                @if ($studentValues)
                                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Nilai Anda</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Ternormalisasi</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Terbobot</th>
                                @endif
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groupKriteria as $item)
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-navy text-white">
                                            {{ $item->kode_kriteria }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 font-medium text-gray-900">{{ $item->nama_kriteria }}</td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center space-x-2">
                                            <span class="font-medium">{{ number_format($item->bobot * 100, 1) }}%</span>
                                            <div class="w-16 bg-gray-200 rounded-full h-2">
                                                <div class="bg-navy h-2 rounded-full"
                                                    style="width: {{ $item->bobot * 100 }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    @if ($studentValues && isset($studentValues[strtoupper($item->kode_kriteria)]))
                                        @php $values = $studentValues[strtoupper($item->kode_kriteria)] @endphp
                                        <td class="py-3 px-4 text-sm">{{ $values['raw'] }}</td>
                                        <td class="py-3 px-4 text-sm font-mono">
                                            {{ number_format($values['normalized'], 6) }}</td>
                                        <td class="py-3 px-4 text-sm font-mono">{{ number_format($values['weighted'], 6) }}
                                        </td>
                                    @endif
                                    <td class="py-3 px-4 text-sm text-gray-600">{{ $item->keterangan ?: '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach

        @if ($studentValues)
            <!-- Your Performance Summary -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-navy mb-4">Ringkasan Performa Anda</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Nilai Akademik -->
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <h4 class="font-medium text-blue-800 mb-3">Nilai Akademik</h4>
                        <div class="space-y-2">
                            @foreach (['N1', 'N2', 'N3', 'N4', 'N5', 'N6'] as $code)
                                @if (isset($studentValues[$code]))
                                    @php
                                        $rawValue = $studentValues[$code]['raw'];
                                        $colorClass =
                                            $rawValue >= 85
                                                ? 'text-green-600'
                                                : ($rawValue >= 75
                                                    ? 'text-yellow-600'
                                                    : 'text-red-600');
                                    @endphp
                                    <div class="flex justify-between items-center text-sm">
                                        <span>{{ $code }}:</span>
                                        <span class="font-medium {{ $colorClass }}">{{ $rawValue }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Minat -->
                    <div class="p-4 bg-green-50 rounded-lg">
                        <h4 class="font-medium text-green-800 mb-3">Minat</h4>
                        <div class="space-y-2">
                            @foreach (['MA', 'MB', 'MC', 'MD'] as $code)
                                @if (isset($studentValues[$code]))
                                    <div class="text-sm">
                                        <span class="text-gray-600">{{ $code }}:</span>
                                        <span class="font-medium">{{ $studentValues[$code]['raw'] }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Lainnya -->
                    <div class="p-4 bg-purple-50 rounded-lg">
                        <h4 class="font-medium text-purple-800 mb-3">Keahlian & Ekonomi</h4>
                        <div class="space-y-2">
                            @foreach (['BB', 'BP'] as $code)
                                @if (isset($studentValues[$code]))
                                    <div class="text-sm">
                                        <span class="text-gray-600">{{ $code }}:</span>
                                        <span class="font-medium">{{ $studentValues[$code]['raw'] }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- TOPSIS Process Explanation -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-navy mb-4">Proses Perhitungan TOPSIS</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-medium text-gray-900 mb-3">Langkah Normalisasi</h4>
                    <div class="text-sm text-gray-600 space-y-2">
                        <p>1. Setiap nilai dibagi dengan akar kuadrat dari jumlah kuadrat semua nilai pada kolom yang sama
                        </p>
                        <p>2. Rumus: r<sub>ij</sub> = x<sub>ij</sub> / √(Σx<sub>ij</sub>²)</p>
                        <p>3. Hasil normalisasi berkisar antara 0-1</p>
                    </div>
                </div>

                <div>
                    <h4 class="font-medium text-gray-900 mb-3">Langkah Pembobotan</h4>
                    <div class="text-sm text-gray-600 space-y-2">
                        <p>1. Nilai ternormalisasi dikalikan dengan bobot kriteria</p>
                        <p>2. Rumus: v<sub>ij</sub> = w<sub>j</sub> × r<sub>ij</sub></p>
                        <p>3. Bobot mencerminkan tingkat kepentingan kriteria</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('student.analisis.index') }}"
                class="flex-1 bg-navy text-white px-6 py-3 rounded-lg hover:bg-navy-dark transition duration-200 text-center font-medium">
                Kembali ke Analisis
            </a>
            @if ($studentValues)
                <a href="{{ route('student.analisis.topsis') }}"
                    class="flex-1 bg-white border border-navy text-navy px-6 py-3 rounded-lg hover:bg-navy hover:text-white transition duration-200 text-center font-medium">
                    Lihat Perhitungan TOPSIS
                </a>
            @endif
        </div>
    </div>
@endsection
