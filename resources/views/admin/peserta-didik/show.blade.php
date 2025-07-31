@extends('layouts.admin')

@section('title', 'Detail Peserta Didik')
@section('page-title', 'Detail Peserta Didik')
@section('page-description', $pesertaDidik->nama_lengkap . ' - ' . $pesertaDidik->nisn)

@section('content')
    <div class="space-y-6">
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.peserta-didik.index') }}"
                    class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-lg font-semibold text-navy">{{ $pesertaDidik->nama_lengkap }}</h2>
                    <p class="text-sm text-gray-600">NISN: {{ $pesertaDidik->nisn }}</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.peserta-didik.edit', $pesertaDidik) }}"
                    class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Data
                </a>
                @if (!$pesertaDidik->penilaian->count())
                    <a href="{{ route('admin.peserta-didik.penilaian.create', $pesertaDidik) }}"
                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Penilaian
                    </a>
                @endif
            </div>
        </div>

        <!-- Profile Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-navy to-navy-dark">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-gold rounded-full flex items-center justify-center">
                        <span class="text-navy font-bold text-xl">{{ substr($pesertaDidik->nama_lengkap, 0, 1) }}</span>
                    </div>
                    <div class="text-white">
                        <h3 class="text-xl font-bold">{{ $pesertaDidik->nama_lengkap }}</h3>
                        <p class="text-blue-100">{{ $pesertaDidik->nisn }} • {{ $pesertaDidik->jenis_kelamin_lengkap }}</p>
                        <p class="text-blue-200 text-sm">Tahun Ajaran: {{ $pesertaDidik->tahun_ajaran }}</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div>
                        <h4 class="text-lg font-semibold text-navy mb-4">Informasi Personal</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">Tanggal Lahir:</span>
                                <span class="font-medium">
                                    @if ($pesertaDidik->tanggal_lahir)
                                        {{ \Carbon\Carbon::parse($pesertaDidik->tanggal_lahir)->format('d F Y') }}
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">Umur:</span>
                                <span class="font-medium">
                                    @if ($pesertaDidik->tanggal_lahir)
                                        {{ \Carbon\Carbon::parse($pesertaDidik->tanggal_lahir)->age }} tahun
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">No. Telepon:</span>
                                <span class="font-medium">{{ $pesertaDidik->no_telepon ?: '-' }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">Email:</span>
                                <span class="font-medium">{{ $pesertaDidik->user->email ?? '-' }}</span>
                            </div>
                            <div class="py-2">
                                <span class="text-gray-600">Alamat:</span>
                                <p class="font-medium mt-1">{{ $pesertaDidik->alamat ?: '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Family Information -->
                    <div>
                        <h4 class="text-lg font-semibold text-navy mb-4">Informasi Keluarga</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">Nama Orang Tua:</span>
                                <span class="font-medium">{{ $pesertaDidik->nama_orang_tua ?: '-' }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">No. Telepon Orang Tua:</span>
                                <span class="font-medium">{{ $pesertaDidik->no_telepon_orang_tua ?: '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div>
                        <h4 class="text-lg font-semibold text-navy mb-4">Informasi Akun</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">Username:</span>
                                <span class="font-medium">{{ $pesertaDidik->user->username ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">Status Akun:</span>
                                <span class="font-medium">
                                    @if ($pesertaDidik->user && $pesertaDidik->user->is_active)
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
                                </span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">Terdaftar:</span>
                                <span class="font-medium">
                                    @if ($pesertaDidik->created_at)
                                        {{ $pesertaDidik->created_at->format('d F Y') }}
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Academic Status -->
                    <div>
                        <h4 class="text-lg font-semibold text-navy mb-4">Status Akademik</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">Data Penilaian:</span>
                                <span class="font-medium">
                                    @if ($pesertaDidik->penilaian->count())
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ $pesertaDidik->penilaian->count() }} data
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Belum ada
                                        </span>
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">Perhitungan TOPSIS:</span>
                                <span class="font-medium">
                                    @if ($pesertaDidik->perhitunganTopsis->count())
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $pesertaDidik->perhitunganTopsis->count() }} perhitungan
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Belum dihitung
                                        </span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TOPSIS Results -->
        @if ($pesertaDidik->perhitunganTopsis->count())
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-navy">Hasil Perhitungan TOPSIS</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tahun Ajaran</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nilai Preferensi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rekomendasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal Hitung</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($pesertaDidik->perhitunganTopsis as $perhitungan)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $perhitungan->tahun_ajaran }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ number_format($perhitungan->nilai_preferensi, 4) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $perhitungan->rekomendasi_lengkap }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if ($perhitungan->tanggal_perhitungan)
                                            {{ $perhitungan->tanggal_perhitungan->format('d/m/Y H:i') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.perhitungan.detail', $pesertaDidik) }}"
                                            class="text-navy hover:text-navy-dark">Lihat Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Assessment Data -->
        @if ($pesertaDidik->penilaian->count())
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-navy">Data Penilaian</h3>
                        <a href="{{ route('admin.peserta-didik.penilaian.create', $pesertaDidik) }}"
                            class="text-navy hover:text-navy-dark text-sm font-medium">
                            + Tambah Penilaian Baru
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tahun Ajaran</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rata-rata Nilai</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal Input</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($pesertaDidik->penilaian as $penilaian)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $penilaian->tahun_ajaran }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ number_format($penilaian->rata_nilai_akademik, 1) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($penilaian->sudah_dihitung)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Sudah Dihitung
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Perlu Dihitung
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if ($penilaian->created_at)
                                            {{ $penilaian->created_at->format('d/m/Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="{{ route('admin.peserta-didik.penilaian.edit', [$pesertaDidik, $penilaian]) }}"
                                            class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                        <form method="POST"
                                            action="{{ route('admin.peserta-didik.penilaian.destroy', [$pesertaDidik, $penilaian]) }}"
                                            class="inline"
                                            onsubmit="return confirm('Yakin ingin menghapus penilaian ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

@endsection
