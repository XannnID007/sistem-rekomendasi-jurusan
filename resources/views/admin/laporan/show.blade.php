@extends('layouts.admin')

@section('title', 'Detail Laporan')
@section('page-title', 'Detail Laporan')
@section('page-description', $laporan->judul_laporan)

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-12 h-12 bg-navy rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-navy">{{ $laporan->judul_laporan }}</h1>
                            <p class="text-gray-600">{{ $laporan->jenis_laporan_indonesia }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <span class="text-sm text-gray-500">Tahun Ajaran</span>
                            <p class="font-medium">{{ $laporan->tahun_ajaran }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Dibuat Oleh</span>
                            <p class="font-medium">{{ $laporan->pembuatLaporan->full_name }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Tanggal Dibuat</span>
                            <p class="font-medium">{{ $laporan->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Status</span>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Tersedia
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex space-x-3">
                    @if ($laporan->file_path)
                        <a href="{{ route('admin.laporan.download', $laporan) }}"
                            class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Download
                        </a>
                    @endif

                    <form method="POST" action="{{ route('admin.laporan.destroy', $laporan) }}" class="inline"
                        onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Report Content -->
        @if ($laporan->jenis_laporan === 'individual')
            <!-- Individual Report -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-navy mb-4">Ringkasan Laporan Individual</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600 mb-1">{{ $reportData['total_siswa'] }}</div>
                        <div class="text-sm text-gray-600">Total Siswa</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600 mb-1">
                            {{ number_format($reportData['rata_preferensi'], 4) }}</div>
                        <div class="text-sm text-gray-600">Rata-rata Preferensi</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600 mb-1">{{ $reportData['tkj_count'] }}</div>
                        <div class="text-sm text-gray-600">Rekomendasi TKJ</div>
                    </div>
                    <div class="text-center p-4 bg-yellow-50 rounded-lg">
                        <div class="text-2xl font-bold text-yellow-600 mb-1">{{ $reportData['tkr_count'] }}</div>
                        <div class="text-sm text-gray-600">Rekomendasi TKR</div>
                    </div>
                </div>

                <!-- Students List -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    NISN</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nilai Preferensi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rekomendasi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($reportData['perhitungan'] as $index => $perhitungan)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $perhitungan->pesertaDidik->nisn }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ number_format($perhitungan->nilai_preferensi, 4) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $perhitungan->rekomendasi_lengkap }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @elseif($laporan->jenis_laporan === 'ringkasan')
            <!-- Summary Report -->
            <div class="space-y-6">
                <!-- Statistics Overview -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-navy mb-4">Statistik Keseluruhan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="text-3xl font-bold text-blue-600 mb-2">{{ $reportData['total_siswa'] }}</div>
                            <div class="text-sm text-gray-600">Total Siswa</div>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <div class="text-3xl font-bold text-green-600 mb-2">{{ $reportData['tkj_count'] }}</div>
                            <div class="text-sm text-gray-600">Rekomendasi TKJ</div>
                            <div class="text-xs text-gray-500">
                                {{ number_format(($reportData['tkj_count'] / $reportData['total_siswa']) * 100, 1) }}%
                            </div>
                        </div>
                        <div class="text-center p-4 bg-purple-50 rounded-lg">
                            <div class="text-3xl font-bold text-purple-600 mb-2">{{ $reportData['tkr_count'] }}</div>
                            <div class="text-sm text-gray-600">Rekomendasi TKR</div>
                            <div class="text-xs text-gray-500">
                                {{ number_format(($reportData['tkr_count'] / $reportData['total_siswa']) * 100, 1) }}%
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Performance Statistics -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-navy mb-4">Statistik Preferensi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center p-4 bg-yellow-50 rounded-lg">
                            <div class="text-2xl font-bold text-yellow-600 mb-1">
                                {{ number_format($reportData['rata_preferensi'], 4) }}</div>
                            <div class="text-sm text-gray-600">Rata-rata</div>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <div class="text-2xl font-bold text-green-600 mb-1">
                                {{ number_format($reportData['tertinggi'], 4) }}</div>
                            <div class="text-sm text-gray-600">Tertinggi</div>
                        </div>
                        <div class="text-center p-4 bg-red-50 rounded-lg">
                            <div class="text-2xl font-bold text-red-600 mb-1">
                                {{ number_format($reportData['terendah'], 4) }}</div>
                            <div class="text-sm text-gray-600">Terendah</div>
                        </div>
                    </div>
                </div>

                <!-- Gender Distribution -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-navy mb-4">Distribusi Gender</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600 mb-1">
                                {{ $reportData['distribusi_gender']['laki'] }}</div>
                            <div class="text-sm text-gray-600">Laki-laki</div>
                            <div class="text-xs text-gray-500">
                                {{ number_format(($reportData['distribusi_gender']['laki'] / $reportData['total_siswa']) * 100, 1) }}%
                            </div>
                        </div>
                        <div class="text-center p-4 bg-pink-50 rounded-lg">
                            <div class="text-2xl font-bold text-pink-600 mb-1">
                                {{ $reportData['distribusi_gender']['perempuan'] }}</div>
                            <div class="text-sm text-gray-600">Perempuan</div>
                            <div class="text-xs text-gray-500">
                                {{ number_format(($reportData['distribusi_gender']['perempuan'] / $reportData['total_siswa']) * 100, 1) }}%
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Performers -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-navy mb-4">Top 10 Performer</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ranking</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nilai Preferensi</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Rekomendasi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($reportData['top_performers'] as $index => $perhitungan)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-8 h-8 {{ $index < 3 ? 'bg-gold' : 'bg-gray-100' }} rounded-full flex items-center justify-center mr-3">
                                                    <span
                                                        class="text-sm font-bold {{ $index < 3 ? 'text-navy' : 'text-gray-600' }}">{{ $index + 1 }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $perhitungan->pesertaDidik->nama_lengkap }}</div>
                                            <div class="text-sm text-gray-500">{{ $perhitungan->pesertaDidik->nisn }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ number_format($perhitungan->nilai_preferensi, 4) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                                {{ $perhitungan->jurusan_rekomendasi }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @elseif($laporan->jenis_laporan === 'perbandingan')
            <!-- Comparison Report -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-navy mb-4">Perbandingan Antar Tahun Ajaran</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tahun Ajaran</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Siswa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    TKJ</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    TKR</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rata-rata Preferensi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tertinggi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Terendah</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($reportData['comparison'] as $tahun => $stats)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $tahun }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $stats['total_siswa'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $stats['tkj_count'] }}</div>
                                        <div class="text-xs text-gray-500">
                                            {{ number_format(($stats['tkj_count'] / $stats['total_siswa']) * 100, 1) }}%
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $stats['tkr_count'] }}</div>
                                        <div class="text-xs text-gray-500">
                                            {{ number_format(($stats['tkr_count'] / $stats['total_siswa']) * 100, 1) }}%
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ number_format($stats['rata_preferensi'], 4) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ number_format($stats['tertinggi'], 4) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ number_format($stats['terendah'], 4) }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @elseif($laporan->jenis_laporan === 'recommendation_filter')
            <!-- Recommendation Filter Report -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                @php
                    $filterType = $reportData['filter_type'] ?? 'all';
                    $filterTitles = [
                        'TKJ' => 'TKJ (Teknik Komputer dan Jaringan)',
                        'TKR' => 'TKR (Teknik Kendaraan Ringan)',
                        'all' => 'Semua Rekomendasi',
                    ];
                @endphp

                <h3 class="text-lg font-semibold text-navy mb-4">
                    Laporan Filter: {{ $filterTitles[$filterType] ?? 'Unknown' }}
                </h3>

                <!-- Filter Info -->
                <div class="bg-blue-50 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        <span class="text-blue-800 font-medium">
                            Filter Diterapkan: {{ $filterTitles[$filterType] ?? 'Unknown' }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600 mb-1">{{ $reportData['total_siswa'] ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Total Siswa</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600 mb-1">
                            {{ number_format($reportData['rata_preferensi'] ?? 0, 4) }}
                        </div>
                        <div class="text-sm text-gray-600">Rata-rata Preferensi</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600 mb-1">
                            {{ number_format($reportData['tertinggi'] ?? 0, 4) }}
                        </div>
                        <div class="text-sm text-gray-600">Nilai Tertinggi</div>
                    </div>
                    <div class="text-center p-4 bg-yellow-50 rounded-lg">
                        <div class="text-2xl font-bold text-yellow-600 mb-1">
                            {{ number_format($reportData['terendah'] ?? 0, 4) }}
                        </div>
                        <div class="text-sm text-gray-600">Nilai Terendah</div>
                    </div>
                </div>

                <!-- Gender Distribution -->
                @if (isset($reportData['distribusi_gender']))
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600 mb-1">
                                {{ $reportData['distribusi_gender']['laki'] ?? 0 }}
                            </div>
                            <div class="text-sm text-gray-600">Laki-laki</div>
                            <div class="text-xs text-gray-500">
                                @if (($reportData['total_siswa'] ?? 0) > 0)
                                    {{ number_format(($reportData['distribusi_gender']['laki'] / $reportData['total_siswa']) * 100, 1) }}%
                                @else
                                    0%
                                @endif
                            </div>
                        </div>
                        <div class="text-center p-4 bg-pink-50 rounded-lg">
                            <div class="text-2xl font-bold text-pink-600 mb-1">
                                {{ $reportData['distribusi_gender']['perempuan'] ?? 0 }}
                            </div>
                            <div class="text-sm text-gray-600">Perempuan</div>
                            <div class="text-xs text-gray-500">
                                @if (($reportData['total_siswa'] ?? 0) > 0)
                                    {{ number_format(($reportData['distribusi_gender']['perempuan'] / $reportData['total_siswa']) * 100, 1) }}%
                                @else
                                    0%
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Performance Statistics -->
                @if (isset($reportData['statistics']))
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <h4 class="text-md font-semibold text-navy mb-3">Distribusi Tingkat Nilai Preferensi</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="text-center p-3 bg-green-100 rounded-lg">
                                <div class="text-lg font-bold text-green-600">
                                    {{ $reportData['statistics']['nilai_tinggi'] ?? 0 }}</div>
                                <div class="text-xs text-gray-600">Tinggi (> 0.50)</div>
                                <div class="text-xs text-gray-500">
                                    {{ number_format($reportData['statistics']['persentase_tinggi'] ?? 0, 1) }}%</div>
                            </div>
                            <div class="text-center p-3 bg-yellow-100 rounded-lg">
                                <div class="text-lg font-bold text-yellow-600">
                                    {{ $reportData['statistics']['nilai_sedang'] ?? 0 }}</div>
                                <div class="text-xs text-gray-600">Sedang (0.30-0.50)</div>
                                <div class="text-xs text-gray-500">
                                    {{ number_format($reportData['statistics']['persentase_sedang'] ?? 0, 1) }}%</div>
                            </div>
                            <div class="text-center p-3 bg-red-100 rounded-lg">
                                <div class="text-lg font-bold text-red-600">
                                    {{ $reportData['statistics']['nilai_rendah'] ?? 0 }}</div>
                                <div class="text-xs text-gray-600">Rendah (< 0.30)</div>
                                        <div class="text-xs text-gray-500">
                                            {{ number_format($reportData['statistics']['persentase_rendah'] ?? 0, 1) }}%
                                        </div>
                                </div>
                            </div>
                        </div>
                @endif

                <!-- Students Table -->
                @if (isset($reportData['data_lengkap']) && $reportData['data_lengkap']->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        NISN</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        L/P</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nilai Preferensi</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Rekomendasi</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kategori</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($reportData['data_lengkap'] as $index => $perhitungan)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $perhitungan->pesertaDidik->nama_lengkap }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $perhitungan->pesertaDidik->nisn }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $perhitungan->pesertaDidik->jenis_kelamin }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ number_format($perhitungan->nilai_preferensi, 4) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                                {{ $perhitungan->jurusan_rekomendasi }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @php
                                                $nilai = $perhitungan->nilai_preferensi;
                                                $kategori =
                                                    $nilai > 0.5 ? 'Tinggi' : ($nilai >= 0.3 ? 'Sedang' : 'Rendah');
                                                $colorClass =
                                                    $nilai > 0.5
                                                        ? 'text-green-600'
                                                        : ($nilai >= 0.3
                                                            ? 'text-yellow-600'
                                                            : 'text-red-600');
                                            @endphp
                                            <span class="{{ $colorClass }} font-medium">{{ $kategori }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500">Tidak ada data siswa untuk filter yang dipilih</p>
                    </div>
                @endif
            </div>
        @endif

        <!-- Report Parameters -->
        @if ($laporan->parameter && count($laporan->parameter) > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-navy mb-4">Parameter Laporan</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <pre class="text-sm text-gray-700">{{ json_encode($laporan->parameter, JSON_PRETTY_PRINT) }}</pre>
                </div>
            </div>
        @endif

        <!-- Actions -->
        <div class="flex justify-between">
            <a href="{{ route('admin.laporan.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar Laporan
            </a>

            <div class="flex space-x-3">
                <button onclick="window.print()"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print
                </button>

                @if ($laporan->file_path)
                    <a href="{{ route('admin.laporan.download', $laporan) }}"
                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Download PDF
                    </a>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            @media print {
                .no-print {
                    display: none !important;
                }

                .print-break {
                    page-break-before: always;
                }

                body {
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }
            }
        </style>
    @endpush
@endsection
