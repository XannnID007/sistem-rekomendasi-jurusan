@extends('layouts.admin')

@section('title', 'Kelola Laporan')
@section('page-title', 'Kelola Laporan')
@section('page-description', 'Manajemen dan cetak laporan sistem')

@section('content')
    <div class="space-y-6">
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
            <div>
                <h2 class="text-lg font-semibold text-navy">Daftar Laporan</h2>
                <p class="text-sm text-gray-600 mt-1">Total: {{ $laporan->total() }} laporan</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.laporan.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy-dark transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Buat Laporan
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Judul laporan..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent">
                </div>

                <!-- Report Type Filter -->
                <div>
                    <label for="jenis_laporan" class="block text-sm font-medium text-gray-700 mb-1">Jenis Laporan</label>
                    <select name="jenis_laporan" id="jenis_laporan"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent">
                        <option value="">Semua Jenis</option>
                        <option value="individual" {{ request('jenis_laporan') === 'individual' ? 'selected' : '' }}>
                            Individual
                        </option>
                        <option value="ringkasan" {{ request('jenis_laporan') === 'ringkasan' ? 'selected' : '' }}>
                            Ringkasan
                        </option>
                        <option value="perbandingan" {{ request('jenis_laporan') === 'perbandingan' ? 'selected' : '' }}>
                            Perbandingan
                        </option>
                        <option value="recommendation_filter"
                            {{ request('jenis_laporan') === 'recommendation_filter' ? 'selected' : '' }}>
                            Filter Rekomendasi
                        </option>
                    </select>
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

                <!-- Filter Buttons -->
                <div class="flex items-end space-x-2">
                    <button type="submit"
                        class="px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy-dark transition duration-200">
                        Filter
                    </button>
                    <a href="{{ route('admin.laporan.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-200">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Reports Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Laporan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jenis
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tahun Ajaran
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dibuat Oleh
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($laporan as $report)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $report->judul_laporan }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if ($report->jenis_laporan === 'individual') bg-blue-100 text-blue-800
                                        @elseif($report->jenis_laporan === 'ringkasan') bg-green-100 text-green-800
                                        @elseif($report->jenis_laporan === 'perbandingan') bg-purple-100 text-purple-800
                                        @elseif($report->jenis_laporan === 'recommendation_filter') bg-orange-100 text-orange-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $report->jenis_laporan_indonesia }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $report->tahun_ajaran }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $report->pembuatLaporan->full_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $report->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.laporan.show', $report) }}"
                                        class="text-navy hover:text-navy-dark" title="Lihat Detail">
                                        <svg class="w-4 h-4 inline" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    @if ($report->file_path)
                                        <a href="{{ route('admin.laporan.download', $report) }}"
                                            class="text-green-600 hover:text-green-900" title="Download">
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </a>
                                    @endif
                                    <form method="POST" action="{{ route('admin.laporan.destroy', $report) }}"
                                        class="inline" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-gray-500 text-lg">Belum ada laporan</p>
                                        <p class="text-gray-400 text-sm mt-1">Buat laporan pertama Anda</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($laporan->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $laporan->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal for Report Generation (placeholder - implement based on needs) -->
    <div id="reportModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl max-w-md w-full p-6">
                <h3 id="modalTitle" class="text-lg font-semibold mb-4">Buat Laporan</h3>
                <p class="text-gray-600 mb-4">Fitur ini akan segera tersedia. Silakan gunakan menu "Buat Laporan" untuk
                    sementara.</p>
                <div class="flex justify-end">
                    <button onclick="closeModal()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function openModal(type) {
                const modal = document.getElementById('reportModal');
                const title = document.getElementById('modalTitle');

                switch (type) {
                    case 'individual':
                        title.textContent = 'Buat Laporan Individual';
                        break;
                    case 'summary':
                        title.textContent = 'Buat Laporan Ringkasan';
                        break;
                    case 'comparison':
                        title.textContent = 'Buat Laporan Perbandingan';
                        break;
                }

                modal.classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('reportModal').classList.add('hidden');
            }

            // Auto-submit form on filter change
            document.querySelectorAll('select[name="jenis_laporan"], select[name="tahun_ajaran"]').forEach(function(select) {
                select.addEventListener('change', function() {
                    this.form.submit();
                });
            });
        </script>
    @endpush

@endsection
