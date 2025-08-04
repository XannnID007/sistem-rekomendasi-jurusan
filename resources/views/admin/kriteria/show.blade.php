@extends('layouts.admin')

@section('title', 'Detail Kriteria')
@section('page-title', 'Detail Kriteria')
@section('page-description', $kriteria->nama_kriteria . ' (' . $kriteria->kode_kriteria . ')')

@section('content')
    <div class="space-y-6">
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.kriteria.index') }}"
                    class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-lg font-semibold text-navy">{{ $kriteria->nama_kriteria }}</h2>
                    <p class="text-sm text-gray-600">{{ $kriteria->kode_kriteria }}</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.kriteria.edit', $kriteria) }}"
                    class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Kriteria
                </a>
            </div>
        </div>

        <!-- Main Information Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-navy to-navy-dark">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-gold rounded-full flex items-center justify-center">
                        <span class="text-navy font-bold text-xl">{{ $kriteria->kode_kriteria }}</span>
                    </div>
                    <div class="text-white">
                        <h3 class="text-xl font-bold">{{ $kriteria->nama_kriteria }}</h3>
                        <p class="text-blue-100">Kode: {{ $kriteria->kode_kriteria }}</p>
                        <p class="text-blue-200 text-sm">
                            Status:
                            @if ($kriteria->is_active)
                                <span class="text-green-300">Aktif</span>
                            @else
                                <span class="text-red-300">Nonaktif</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-semibold text-navy mb-4">Informasi Dasar</h4>

                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-600">Kode Kriteria:</span>
                            <span class="font-medium text-navy">{{ $kriteria->kode_kriteria }}</span>
                        </div>

                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-600">Nama Kriteria:</span>
                            <span class="font-medium">{{ $kriteria->nama_kriteria }}</span>
                        </div>

                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-600">Jenis Kriteria:</span>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $kriteria->jenis_kriteria === 'benefit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $kriteria->jenis_kriteria_indonesia }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-600">Status:</span>
                            @if ($kriteria->is_active)
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Aktif
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Nonaktif
                                </span>
                            @endif
                        </div>

                        <div class="py-2">
                            <span class="text-gray-600">Keterangan:</span>
                            <p class="font-medium mt-1">{{ $kriteria->keterangan ?: 'Tidak ada keterangan' }}</p>
                        </div>
                    </div>

                    <!-- Weight Information -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-semibold text-navy mb-4">Informasi Bobot</h4>

                        <div class="text-center p-6 bg-gray-50 rounded-lg">
                            <div class="text-4xl font-bold text-navy mb-2">{{ $kriteria->bobot_persen }}</div>
                            <div class="text-sm text-gray-600 mb-4">Bobot Kriteria</div>

                            <!-- Visual Weight Bar -->
                            <div class="w-full bg-gray-200 rounded-full h-4">
                                <div class="bg-navy h-4 rounded-full transition-all duration-300"
                                    style="width: {{ $kriteria->bobot * 100 }}%"></div>
                            </div>
                            <div class="text-xs text-gray-500 mt-2">
                                Nilai Decimal: {{ number_format($kriteria->bobot, 4) }}
                            </div>
                        </div>

                        <!-- Criteria Type Explanation -->
                        <div
                            class="p-4 {{ $kriteria->jenis_kriteria === 'benefit' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }} rounded-lg">
                            <h5
                                class="font-medium {{ $kriteria->jenis_kriteria === 'benefit' ? 'text-green-800' : 'text-red-800' }} mb-2">
                                Penjelasan Jenis Kriteria
                            </h5>
                            <p
                                class="text-sm {{ $kriteria->jenis_kriteria === 'benefit' ? 'text-green-700' : 'text-red-700' }}">
                                @if ($kriteria->jenis_kriteria === 'benefit')
                                    Kriteria <strong>Benefit</strong>: Semakin tinggi nilai kriteria ini, semakin baik untuk
                                    perhitungan TOPSIS.
                                    Contoh: nilai akademik, minat, keahlian.
                                @else
                                    Kriteria <strong>Cost</strong>: Semakin rendah nilai kriteria ini, semakin baik untuk
                                    perhitungan TOPSIS.
                                    Contoh: biaya, jarak, risiko.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Usage Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-navy mb-4">Penggunaan dalam TOPSIS</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-2xl font-bold text-navy mb-2">{{ number_format($kriteria->bobot * 100, 2) }}%</div>
                    <div class="text-sm text-gray-600">Kontribusi dalam Perhitungan</div>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-2xl font-bold text-navy mb-2">
                        {{ $kriteria->jenis_kriteria === 'benefit' ? 'MAX' : 'MIN' }}
                    </div>
                    <div class="text-sm text-gray-600">Optimasi dalam TOPSIS</div>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-2xl font-bold text-navy mb-2">
                        {{ $kriteria->is_active ? 'YA' : 'TIDAK' }}
                    </div>
                    <div class="text-sm text-gray-600">Digunakan dalam Perhitungan</div>
                </div>
            </div>
        </div>

        <!-- Meta Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-navy mb-4">Informasi Sistem</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Dibuat:</span>
                        <span class="font-medium">{{ $kriteria->created_at->format('d F Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Terakhir Diubah:</span>
                        <span class="font-medium">{{ $kriteria->updated_at->format('d F Y, H:i') }}</span>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">ID Kriteria:</span>
                        <span class="font-medium">#{{ $kriteria->kriteria_id }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
