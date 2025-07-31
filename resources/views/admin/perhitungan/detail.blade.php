@extends('layouts.admin')

@section('title', 'Detail Perhitungan TOPSIS')
@section('page-title', 'Detail Perhitungan TOPSIS')
@section('page-description', $perhitungan->pesertaDidik->nama_lengkap . ' - ' . $perhitungan->pesertaDidik->nisn)

@section('content')
    <div class="space-y-6">
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.perhitungan.index') }}"
                    class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-lg font-semibold text-navy">{{ $perhitungan->pesertaDidik->nama_lengkap }}</h2>
                    <p class="text-sm text-gray-600">NISN: {{ $perhitungan->pesertaDidik->nisn }}</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.perhitungan.detail', $perhitungan->pesertaDidik) }}"
                    class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Lihat Detail Langkah
                </a>
            </div>
        </div>

        <!-- Result Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-navy to-navy-dark">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-gold rounded-full flex items-center justify-center">
                            <span
                                class="text-navy font-bold text-xl">{{ substr($perhitungan->pesertaDidik->nama_lengkap, 0, 1) }}</span>
                        </div>
                        <div class="text-white">
                            <h3 class="text-xl font-bold">{{ $perhitungan->pesertaDidik->nama_lengkap }}</h3>
                            <p class="text-blue-100">{{ $perhitungan->pesertaDidik->nisn }} •
                                {{ $perhitungan->tahun_ajaran }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-white text-right">
                            <p class="text-lg font-semibold">Nilai Preferensi</p>
                            <p class="text-3xl font-bold text-gold">{{ number_format($perhitungan->nilai_preferensi, 4) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Hasil Rekomendasi -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h4 class="text-lg font-semibold text-navy mb-4">Hasil Rekomendasi</h4>

                        <div class="text-center mb-6">
                            <div
                                class="w-24 h-24 mx-auto mb-4 {{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'bg-blue-100' : 'bg-green-100' }} rounded-full flex items-center justify-center">
                                <span
                                    class="text-2xl font-bold {{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'text-blue-600' : 'text-green-600' }}">
                                    {{ $perhitungan->jurusan_rekomendasi }}
                                </span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $perhitungan->rekomendasi_lengkap }}</h3>
                            <p class="text-gray-600">
                                @if ($perhitungan->jurusan_rekomendasi === 'TKJ')
                                    Siswa ini direkomendasikan untuk jurusan Teknik Komputer dan Jaringan
                                @else
                                    Siswa ini direkomendasikan untuk jurusan Teknik Kendaraan Ringan
                                @endif
                            </p>
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-600">Nilai Preferensi:</span>
                                <span class="font-semibold">{{ number_format($perhitungan->nilai_preferensi, 4) }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-600">Threshold:</span>
                                <span class="font-semibold">0.3000</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-600">Jarak ke Solusi Positif:</span>
                                <span class="font-semibold">{{ number_format($perhitungan->jarak_positif, 6) }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-600">Jarak ke Solusi Negatif:</span>
                                <span class="font-semibold">{{ number_format($perhitungan->jarak_negatif, 6) }}</span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="text-gray-600">Tanggal Perhitungan:</span>
                                <span class="font-semibold">
                                    @if ($perhitungan->tanggal_perhitungan)
                                        {{ $perhitungan->tanggal_perhitungan->format('d F Y, H:i') }}
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Data Penilaian -->
                    <div>
                        <h4 class="text-lg font-semibold text-navy mb-4">Data Penilaian</h4>

                        @if ($perhitungan->penilaian)
                            <div class="space-y-4">
                                <!-- Nilai Akademik -->
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <h5 class="font-semibold text-blue-800 mb-3">Nilai Akademik</h5>
                                    <div class="grid grid-cols-2 gap-3 text-sm">
                                        <div class="flex justify-between">
                                            <span>IPA:</span>
                                            <span class="font-medium">{{ $perhitungan->penilaian->nilai_ipa }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>IPS:</span>
                                            <span class="font-medium">{{ $perhitungan->penilaian->nilai_ips }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Matematika:</span>
                                            <span
                                                class="font-medium">{{ $perhitungan->penilaian->nilai_matematika }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>B. Indonesia:</span>
                                            <span
                                                class="font-medium">{{ $perhitungan->penilaian->nilai_bahasa_indonesia }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>B. Inggris:</span>
                                            <span
                                                class="font-medium">{{ $perhitungan->penilaian->nilai_bahasa_inggris }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Produktif:</span>
                                            <span class="font-medium">{{ $perhitungan->penilaian->nilai_produktif }}</span>
                                        </div>
                                    </div>
                                    <div class="mt-3 pt-3 border-t border-blue-200">
                                        <div class="flex justify-between font-semibold">
                                            <span>Rata-rata:</span>
                                            <span>{{ number_format($perhitungan->penilaian->rata_nilai_akademik, 1) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Minat -->
                                <div class="bg-green-50 p-4 rounded-lg">
                                    <h5 class="font-semibold text-green-800 mb-3">Data Minat</h5>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span>Minat A:</span>
                                            <span class="font-medium">{{ $perhitungan->penilaian->minat_a }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Minat B:</span>
                                            <span class="font-medium">{{ $perhitungan->penilaian->minat_b }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Minat C:</span>
                                            <span class="font-medium">{{ $perhitungan->penilaian->minat_c }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Minat D:</span>
                                            <span class="font-medium">{{ $perhitungan->penilaian->minat_d }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Keahlian & Ekonomi -->
                                <div class="bg-purple-50 p-4 rounded-lg">
                                    <h5 class="font-semibold text-purple-800 mb-3">Keahlian & Ekonomi</h5>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span>Keahlian:</span>
                                            <span class="font-medium">{{ $perhitungan->penilaian->keahlian }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Penghasilan Ortu:</span>
                                            <span
                                                class="font-medium">{{ $perhitungan->penilaian->penghasilan_ortu }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500">Data penilaian tidak ditemukan</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- TOPSIS Process Overview -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-navy mb-6">Ringkasan Proses TOPSIS</h3>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-blue-600 font-bold">1</span>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Normalisasi</h4>
                    <p class="text-sm text-gray-600">Matriks keputusan dinormalisasi menggunakan metode euclidean</p>
                </div>

                <!-- Step 2 -->
                <div class="text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-green-600 font-bold">2</span>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Pembobotan</h4>
                    <p class="text-sm text-gray-600">Nilai ternormalisasi dikalikan dengan bobot kriteria</p>
                </div>

                <!-- Step 3 -->
                <div class="text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-purple-600 font-bold">3</span>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Solusi Ideal</h4>
                    <p class="text-sm text-gray-600">Menentukan solusi ideal positif dan negatif</p>
                </div>

                <!-- Step 4 -->
                <div class="text-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-yellow-600 font-bold">4</span>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Preferensi</h4>
                    <p class="text-sm text-gray-600">Menghitung nilai preferensi dan menentukan rekomendasi</p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('admin.perhitungan.detail', $perhitungan->pesertaDidik) }}"
                class="flex-1 bg-navy text-white px-6 py-3 rounded-lg hover:bg-navy-dark transition duration-200 text-center font-medium">
                Lihat Detail Perhitungan
            </a>
            <a href="{{ route('admin.peserta-didik.show', $perhitungan->pesertaDidik) }}"
                class="flex-1 bg-white border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition duration-200 text-center font-medium">
                Lihat Data Peserta Didik
            </a>
            <form method="POST" action="{{ route('admin.perhitungan.destroy', $perhitungan) }}" class="flex-1"
                onsubmit="return confirm('Yakin ingin menghapus perhitungan ini? Tindakan ini tidak dapat dibatalkan.')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition duration-200 font-medium">
                    Hapus Perhitungan
                </button>
            </form>
        </div>
    </div>

@endsection
