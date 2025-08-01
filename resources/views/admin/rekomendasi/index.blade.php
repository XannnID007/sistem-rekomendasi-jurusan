@extends('layouts.admin')

@section('title', 'Hasil Rekomendasi')
@section('page-title', 'Hasil Rekomendasi Jurusan')
@section('page-description', 'Hasil analisis TOPSIS untuk pemilihan jurusan')

@section('content')
    <div class="space-y-6">
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
            <div>
                <h2 class="text-lg font-semibold text-navy">Daftar Rekomendasi</h2>
                <p class="text-sm text-gray-600 mt-1">Total: {{ $rekomendasi->total() }} rekomendasi</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.rekomendasi.export', ['format' => 'excel']) }}"
                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export Excel
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
            <!-- Total Rekomendasi -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Total Rekomendasi</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $statistics['total'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Rekomendasi TKJ -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Rekomendasi TKJ</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $statistics['tkj'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Rekomendasi TKR -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Rekomendasi TKR</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $statistics['tkr'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Rata-rata Preferensi -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Rata-rata Preferensi</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ number_format($statistics['rata_preferensi'] ?? 0, 3) }}</p>
                    </div>
                </div>
            </div>

            <!-- Nilai Tertinggi -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Tertinggi</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ number_format($statistics['tertinggi'] ?? 0, 3) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Nama atau NISN..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent">
                </div>

                <!-- Academic Year Filter -->
                <div>
                    <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran</label>
                    <select name="tahun_ajaran" id="tahun_ajaran"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent">
                        <option value="">Semua Tahun</option>
                        @foreach ($tahunAjaran as $tahun)
                            <option value="{{ $tahun }}" {{ request('tahun_ajaran') === $tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Recommendation Filter -->
                <div>
                    <label for="jurusan_rekomendasi"
                        class="block text-sm font-medium text-gray-700 mb-1">Rekomendasi</label>
                    <select name="jurusan_rekomendasi" id="jurusan_rekomendasi"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent">
                        <option value="">Semua Jurusan</option>
                        <option value="TKJ" {{ request('jurusan_rekomendasi') === 'TKJ' ? 'selected' : '' }}>TKJ
                        </option>
                        <option value="TKR" {{ request('jurusan_rekomendasi') === 'TKR' ? 'selected' : '' }}>TKR
                        </option>
                    </select>
                </div>

                <!-- Filter Buttons -->
                <div class="flex items-end space-x-2">
                    <button type="submit"
                        class="px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy-dark transition duration-200">
                        Filter
                    </button>
                    <a href="{{ route('admin.rekomendasi.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-200">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Main Content Area with Two Columns -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Left Column: Data Table -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ranking
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Peserta Didik
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nilai Preferensi
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Rekomendasi
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($rekomendasi as $index => $rec)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="w-8 h-8 bg-navy rounded-full flex items-center justify-center">
                                                <span
                                                    class="text-white font-bold text-sm">{{ $rekomendasi->firstItem() + $index }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-10 h-10 bg-gold rounded-full flex items-center justify-center">
                                                    <span
                                                        class="text-navy font-bold text-sm">{{ substr($rec->pesertaDidik->nama_lengkap, 0, 1) }}</span>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $rec->pesertaDidik->nama_lengkap }}</div>
                                                    <div class="text-sm text-gray-500">NISN:
                                                        {{ $rec->pesertaDidik->nisn }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ number_format($rec->nilai_preferensi, 4) }}</div>
                                            <div class="text-xs text-gray-500">
                                                {{ number_format($rec->nilai_preferensi * 100, 2) }}%
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $rec->jurusan_rekomendasi === 'TKJ' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                                {{ $rec->rekomendasi_lengkap }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if ($rec->tanggal_perhitungan)
                                                {{ $rec->tanggal_perhitungan->format('d/m/Y') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <a href="{{ route('admin.rekomendasi.detail', $rec) }}"
                                                class="text-navy hover:text-navy-dark" title="Lihat Detail">
                                                <svg class="w-4 h-4 inline" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.perhitungan.detail', $rec->pesertaDidik) }}"
                                                class="text-purple-600 hover:text-purple-900" title="Detail Perhitungan">
                                                <svg class="w-4 h-4 inline" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 00-2 2h-2a2 2 0 01-2-2z" />
                                                </svg>
                                                <p class="text-gray-500 text-lg">Belum ada hasil rekomendasi</p>
                                                <p class="text-gray-400 text-sm mt-1">Lakukan perhitungan TOPSIS terlebih
                                                    dahulu</p>
                                                <a href="{{ route('admin.perhitungan.create') }}"
                                                    class="mt-4 inline-flex items-center px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy-dark transition duration-200">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                    </svg>
                                                    Hitung TOPSIS
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($rekomendasi->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200">
                            {{ $rekomendasi->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Top Performers & Export -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Top Performers -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-navy mb-4">Top 5 Performers</h3>
                    <div class="space-y-3">
                        @forelse($topPerformers as $index => $performer)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gold rounded-full flex items-center justify-center">
                                        <span class="text-navy font-bold text-sm">{{ $index + 1 }}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 text-sm">
                                            {{ Str::limit($performer->pesertaDidik->nama_lengkap, 15) }}</p>
                                        <p class="text-xs text-gray-500">{{ $performer->pesertaDidik->nisn }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="flex flex-col items-end space-y-1">
                                        <span
                                            class="text-sm font-bold text-navy">{{ number_format($performer->nilai_preferensi, 3) }}</span>
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $performer->jurusan_rekomendasi === 'TKJ' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $performer->jurusan_rekomendasi }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-gray-500 text-sm">Belum ada data</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Export Options -->
                @if ($rekomendasi->count() > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-navy mb-4">Export Data</h3>
                        <div class="space-y-3">
                            <a href="{{ route('admin.rekomendasi.export', ['format' => 'excel'] + request()->query()) }}"
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a4 4 0 01-4-4V5a4 4 0 014-4h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a4 4 0 01-4 4z" />
                                </svg>
                                Excel
                            </a>
                            <a href="{{ route('admin.rekomendasi.export', ['format' => 'csv'] + request()->query()) }}"
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                CSV
                            </a>
                            <a href="{{ route('admin.rekomendasi.export', ['format' => 'pdf'] + request()->query()) }}"
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                PDF
                            </a>
                        </div>
                        <p class="text-xs text-gray-500 mt-3">Export mengikuti filter aktif</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Auto-submit form on filter change
            document.querySelectorAll('select[name="tahun_ajaran"], select[name="jurusan_rekomendasi"]').forEach(function(
                select) {
                select.addEventListener('change', function() {
                    this.form.submit();
                });
            });
        </script>
    @endpush

@endsection
