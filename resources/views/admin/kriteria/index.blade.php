@extends('layouts.admin')

@section('title', 'Kelola Kriteria')
@section('page-title', 'Kelola Kriteria')
@section('page-description', 'Manajemen kriteria dan bobot untuk perhitungan TOPSIS')

@section('content')
    <div class="space-y-6">
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
            <div>
                <h2 class="text-lg font-semibold text-navy">Daftar Kriteria TOPSIS</h2>
                <p class="text-sm text-gray-600 mt-1">Total Bobot: {{ number_format($totalBobot * 100, 2) }}%</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.kriteria.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy-dark transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Tambah Kriteria
                </a>
                <form method="POST" action="{{ route('admin.kriteria.reset-weights') }}" class="inline"
                    onsubmit="return confirm('Yakin ingin mereset semua bobot ke nilai default?')">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset Bobot
                    </button>
                </form>
            </div>
        </div>

        <!-- Weight Distribution Alert -->
        @if (abs($totalBobot - 1) > 0.001)
            <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    <div>
                        <h4 class="font-medium text-red-800">Peringatan Bobot</h4>
                        <p class="text-sm text-red-700">Total bobot harus sama dengan 100% (1.0). Saat ini:
                            {{ number_format($totalBobot * 100, 2) }}%</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Kriteria by Category -->
        @foreach ($kriteriaGrouped as $category => $kriteriaList)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-navy">{{ $category }}</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        Bobot Total: {{ number_format($kriteriaList->sum('bobot') * 100, 2) }}%
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Kriteria</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jenis</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Bobot</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($kriteriaList as $k)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-navy text-white">
                                            {{ $k->kode_kriteria }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $k->nama_kriteria }}</div>
                                        @if ($k->keterangan)
                                            <div class="text-sm text-gray-500">{{ $k->keterangan }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $k->jenis_kriteria === 'benefit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $k->jenis_kriteria_indonesia }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $k->bobot_persen }}</div>
                                        <div class="w-20 bg-gray-200 rounded-full h-2 mt-1">
                                            <div class="bg-navy h-2 rounded-full" style="width: {{ $k->bobot * 100 }}%">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($k->is_active)
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
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="{{ route('admin.kriteria.show', $k) }}"
                                            class="text-navy hover:text-navy-dark" title="Lihat Detail">
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.kriteria.edit', $k) }}"
                                            class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.kriteria.destroy', $k) }}"
                                            class="inline" onsubmit="return confirm('Yakin ingin menghapus kriteria ini?')">
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach

        <!-- Information Card -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
            <div class="flex items-start space-x-3">
                <svg class="w-6 h-6 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h4 class="font-medium text-blue-800 mb-2">Informasi Kriteria TOPSIS</h4>
                    <div class="text-sm text-blue-700 space-y-2">
                        <p>• <strong>Benefit:</strong> Semakin tinggi nilai semakin baik (nilai akademik, minat, keahlian)
                        </p>
                        <p>• <strong>Cost:</strong> Semakin rendah nilai semakin baik (biaya, jarak)</p>
                        <p>• Total bobot harus sama dengan 100% (1.0) untuk perhitungan yang akurat</p>
                        <p>• Perubahan bobot akan mempengaruhi hasil perhitungan TOPSIS</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
