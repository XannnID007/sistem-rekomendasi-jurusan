@extends('layouts.student')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('page-description', 'Kelola informasi profil dan pengaturan akun')

@section('content')
    <div class="space-y-6">
        <!-- Profile Header -->
        <div class="bg-gradient-to-r from-navy to-navy-dark rounded-xl p-6 text-white">
            <div class="flex items-center space-x-6">
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-lg">
                    <img src="/images/logo.png" alt="Avatar" class="w-12 h-12 object-contain rounded-full"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <span class="text-navy font-bold text-3xl"
                        style="display: none;">{{ substr($user->full_name, 0, 1) }}</span>
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-bold mb-2">{{ $user->full_name }}</h2>
                    <p class="text-blue-100 mb-1">NISN: {{ $pesertaDidik->nisn }}</p>
                    <p class="text-blue-200 text-sm">{{ $pesertaDidik->tahun_ajaran }} •
                        {{ $pesertaDidik->jenis_kelamin_lengkap }}</p>

                    <!-- Profile Completion -->
                    <div class="mt-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-blue-100">Kelengkapan Profil</span>
                            <span class="text-sm font-medium">{{ $profileCompletion['percentage'] }}%</span>
                        </div>
                        <div class="w-full bg-blue-700 rounded-full h-2">
                            <div class="bg-gold h-2 rounded-full transition-all duration-300"
                                style="width: {{ $profileCompletion['percentage'] }}%"></div>
                        </div>
                        @if ($profileCompletion['percentage'] < 100)
                            <p class="text-xs text-blue-200 mt-1">
                                {{ $profileCompletion['completed_fields'] }} dari {{ $profileCompletion['total_fields'] }}
                                field lengkap
                            </p>
                        @endif
                    </div>
                </div>
                <div class="text-right">
                    <a href="{{ route('student.profil.edit') }}"
                        class="inline-flex items-center px-4 py-2 bg-gold text-navy rounded-lg hover:bg-gold-dark transition duration-200 font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Profil
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Personal Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Info Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-navy">Informasi Personal</h3>
                        <a href="{{ route('student.profil.edit') }}"
                            class="text-navy hover:text-navy-dark text-sm font-medium">
                            Edit
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Nama Lengkap</label>
                                <p class="text-gray-900 font-medium">{{ $pesertaDidik->nama_lengkap }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">NISN</label>
                                <p class="text-gray-900 font-medium">{{ $pesertaDidik->nisn }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Jenis Kelamin</label>
                                <p class="text-gray-900 font-medium">{{ $pesertaDidik->jenis_kelamin_lengkap }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Tanggal Lahir</label>
                                @if ($pesertaDidik->tanggal_lahir)
                                    <p class="text-gray-900 font-medium">
                                        {{ \Carbon\Carbon::parse($pesertaDidik->tanggal_lahir)->format('d F Y') }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Umur: {{ \Carbon\Carbon::parse($pesertaDidik->tanggal_lahir)->age }} tahun
                                    </p>
                                @else
                                    <p class="text-gray-900 font-medium">-</p>
                                @endif
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Email</label>
                                <p class="text-gray-900 font-medium">{{ $user->email }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">No. Telepon</label>
                                <p class="text-gray-900 font-medium">{{ $pesertaDidik->no_telepon ?: '-' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Tahun Ajaran</label>
                                <p class="text-gray-900 font-medium">{{ $pesertaDidik->tahun_ajaran }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Alamat</label>
                                <p class="text-gray-900 font-medium">{{ $pesertaDidik->alamat ?: '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Family Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-navy">Informasi Keluarga</h3>
                        <a href="{{ route('student.profil.edit') }}"
                            class="text-navy hover:text-navy-dark text-sm font-medium">
                            Edit
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Nama Orang Tua</label>
                            <p class="text-gray-900 font-medium">{{ $pesertaDidik->nama_orang_tua ?: '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">No. Telepon Orang Tua</label>
                            <p class="text-gray-900 font-medium">{{ $pesertaDidik->no_telepon_orang_tua ?: '-' }}</p>
                        </div>
                    </div>
                </div>

                @if ($profileCompletion['percentage'] < 100)
                    <!-- Profile Completion Reminder -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                        <div class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-yellow-600 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            <div class="flex-1">
                                <h4 class="font-medium text-yellow-800 mb-1">Lengkapi Profil Anda</h4>
                                <p class="text-sm text-yellow-700 mb-3">
                                    Beberapa informasi masih kosong. Lengkapi profil untuk pengalaman yang lebih baik.
                                </p>
                                @if (isset($profileCompletion['missing_fields']) && count($profileCompletion['missing_fields']) > 0)
                                    <div class="text-sm text-yellow-700">
                                        <strong>Field yang belum diisi:</strong>
                                        <ul class="list-disc list-inside mt-1">
                                            @foreach ($profileCompletion['missing_fields'] as $field)
                                                <li>{{ $field }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="mt-3">
                                    <a href="{{ route('student.profil.edit') }}"
                                        class="inline-flex items-center px-3 py-1 bg-yellow-600 text-white rounded text-sm hover:bg-yellow-700 transition duration-200">
                                        Lengkapi Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Account Status -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-navy mb-4">Status Akun</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Status</span>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $accountActivity['account_status'] ?? 'Aktif' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Terdaftar</span>
                            <span class="text-sm font-medium">
                                @if (isset($accountActivity['account_created']))
                                    {{ \Carbon\Carbon::parse($accountActivity['account_created'])->format('d/m/Y') }}
                                @else
                                    {{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Login Terakhir</span>
                            <span class="text-sm font-medium">
                                @if (isset($accountActivity['last_login']))
                                    {{ \Carbon\Carbon::parse($accountActivity['last_login'])->format('d/m/Y H:i') }}
                                @else
                                    {{ $user->updated_at ? $user->updated_at->format('d/m/Y H:i') : '-' }}
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Academic Status -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-navy mb-4">Status Akademik</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Data Penilaian</span>
                            @if ($pesertaDidik->penilaianTerbaru)
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Tersedia
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Belum Ada
                                </span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Perhitungan TOPSIS</span>
                            @if ($pesertaDidik->perhitunganTerbaru)
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Selesai
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Belum Dihitung
                                </span>
                            @endif
                        </div>
                        @if ($pesertaDidik->perhitunganTerbaru)
                            <div class="pt-2 border-t border-gray-100">
                                <div class="text-center">
                                    <div
                                        class="text-lg font-bold text-{{ $pesertaDidik->perhitunganTerbaru->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-600">
                                        {{ $pesertaDidik->perhitunganTerbaru->jurusan_rekomendasi }}
                                    </div>
                                    <div class="text-xs text-gray-500">Rekomendasi Jurusan</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-navy mb-4">Pengaturan</h3>
                    <div class="space-y-3">
                        <a href="{{ route('student.profil.edit') }}"
                            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition duration-200">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Edit Profil</span>
                        </a>

                        <a href="{{ route('student.profil.password') }}"
                            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition duration-200">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Ubah Password</span>
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center space-x-3 p-3 rounded-lg hover:bg-red-50 transition duration-200 text-left">
                                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-red-600">Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
