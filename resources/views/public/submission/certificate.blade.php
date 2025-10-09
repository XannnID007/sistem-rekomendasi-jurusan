{{-- resources/views/public/submission/certificate.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Hasil Rekomendasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'navy': '#1e3a8a',
                        'gold': '#fbbf24',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50">

    <nav class="bg-white shadow-sm border-b border-gray-200 print:hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-navy rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">SP</span>
                    </div>
                    <h1 class="text-lg font-semibold text-gray-900">Sertifikat Hasil Rekomendasi</h1>
                </div>
                <a href="{{ route('welcome') }}" class="text-navy hover:text-navy-dark text-sm font-medium">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </nav>

    <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto space-y-6">

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-lg print:hidden">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if (session('info'))
                <div class="bg-blue-50 border border-blue-200 text-blue-700 px-6 py-4 rounded-lg print:hidden">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ session('info') }}
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4 print:hidden">
                <button onclick="window.print()"
                    class="bg-navy text-white px-6 py-3 rounded-lg hover:bg-navy-dark transition font-semibold flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    <span>Cetak</span>
                </button>
                <a href="{{ route('submission.download-pdf', $pesertaDidik->nisn) }}"
                    class="bg-gold text-navy px-6 py-3 rounded-lg hover:bg-gold-dark transition font-semibold flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Download PDF</span>
                </a>
            </div>

            <!-- Certificate -->
            <div class="bg-white rounded-2xl shadow-lg border-4 border-navy p-12">

                <!-- Header -->
                <div class="text-center mb-8 border-b-2 border-gray-200 pb-6">
                    <div class="w-24 h-24 bg-navy rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gold" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-navy mb-2">SERTIFIKAT HASIL REKOMENDASI</h1>
                    <p class="text-lg text-gray-600">Sistem Pendukung Keputusan Pemilihan Jurusan</p>
                    <p class="text-sm text-gray-500 mt-2">SMK Penida 2 Katapang</p>
                </div>

                <!-- Content -->
                <div class="space-y-6">
                    <!-- Data Peserta -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="font-bold text-navy mb-4 text-lg">Data Peserta Didik</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Nama Lengkap:</span>
                                <p class="font-semibold text-gray-900">{{ $pesertaDidik->nama_lengkap }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600">NISN:</span>
                                <p class="font-semibold text-gray-900">{{ $pesertaDidik->nisn }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600">Jenis Kelamin:</span>
                                <p class="font-semibold text-gray-900">
                                    {{ $pesertaDidik->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600">Tahun Ajaran:</span>
                                <p class="font-semibold text-gray-900">{{ $pesertaDidik->tahun_ajaran }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Hasil Rekomendasi -->
                    <div
                        class="bg-gradient-to-r from-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-50 to-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-100 rounded-xl p-8 text-center border-2 border-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-200">
                        <p class="text-sm text-gray-600 mb-2">Berdasarkan Metode TOPSIS, Anda Direkomendasikan:</p>
                        <h2
                            class="text-3xl font-bold text-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-900 mb-2">
                            {{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'Teknik Komputer dan Jaringan' : 'Teknik Kendaraan Ringan' }}
                        </h2>
                        <p
                            class="text-xl font-semibold text-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-700">
                            ({{ $perhitungan->jurusan_rekomendasi }})</p>

                        <div class="grid grid-cols-2 gap-4 mt-6">
                            <div class="bg-white rounded-lg p-4">
                                <p class="text-xs text-gray-600">Nilai Preferensi</p>
                                <p class="text-2xl font-bold text-navy">
                                    {{ number_format($perhitungan->nilai_preferensi, 4) }}</p>
                            </div>
                            <div class="bg-white rounded-lg p-4">
                                <p class="text-xs text-gray-600">Tingkat Kesesuaian</p>
                                <p class="text-2xl font-bold text-navy">
                                    {{ number_format($perhitungan->nilai_preferensi * 100, 1) }}%</p>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="font-bold text-navy mb-4">Status Konfirmasi</h3>
                        @if ($penilaian->status_submission === 'approved')
                            <div class="flex items-center space-x-3 text-green-700">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-semibold">DISETUJUI - Peserta didik menyetujui rekomendasi ini</span>
                            </div>
                        @elseif($penilaian->status_submission === 'rejected')
                            <div class="space-y-3">
                                <div class="flex items-center space-x-3 text-orange-700">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="font-semibold">TIDAK DISETUJUI - Peserta didik memilih jurusan
                                        lain</span>
                                </div>
                                <div class="bg-white rounded-lg p-4 text-sm">
                                    <p class="text-gray-600 mb-1">Jurusan yang Dipilih:</p>
                                    <p class="font-bold text-navy">{{ $penilaian->jurusan_dipilih }}</p>
                                    <p class="text-gray-600 mt-3 mb-1">Alasan:</p>
                                    <p class="text-gray-800">{{ $penilaian->alasan_penolakan }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="mt-4 text-sm text-gray-600">
                            <p>Tanggal:
                                @if ($penilaian->tanggal_approved)
                                    @php
                                        $tanggalApproved =
                                            $penilaian->tanggal_approved instanceof \Carbon\Carbon
                                                ? $penilaian->tanggal_approved
                                                : \Carbon\Carbon::parse($penilaian->tanggal_approved);
                                    @endphp
                                    {{ $tanggalApproved->format('d F Y, H:i') }}
                                @else
                                    {{ now()->format('d F Y, H:i') }}
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="border-t-2 border-gray-200 pt-6 mt-8">
                        <div class="grid grid-cols-2 gap-8 text-center text-sm">
                            <div>
                                <p class="text-gray-600 mb-16">Mengetahui,</p>
                                <div class="border-t-2 border-gray-800 pt-2 inline-block px-8">
                                    <p class="font-bold">Kepala Sekolah</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-gray-600 mb-16">Peserta Didik,</p>
                                <div class="border-t-2 border-gray-800 pt-2 inline-block px-8">
                                    <p class="font-bold">{{ $pesertaDidik->nama_lengkap }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-8 text-xs text-gray-500">
                            <p>Dokumen ini digenerate secara otomatis oleh Sistem Pendukung Keputusan</p>
                            <p>SMK Penida 2 Katapang © {{ date('Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info tambahan untuk yang rejected -->
            @if ($penilaian->status_submission === 'rejected')
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 print:hidden">
                    <h4 class="font-bold text-blue-900 mb-2">📞 Informasi Penting</h4>
                    <p class="text-sm text-blue-800">
                        Karena Anda memilih jurusan yang berbeda dari rekomendasi sistem, admin sekolah akan menghubungi
                        Anda melalui:
                    </p>
                    <ul class="list-disc list-inside text-sm text-blue-800 mt-2 space-y-1">
                        <li>Email: {{ $pesertaDidik->email_submission }}</li>
                        <li>No. Telepon: {{ $pesertaDidik->no_telepon_submission }}</li>
                    </ul>
                    <p class="text-sm text-blue-800 mt-3">
                        Pastikan nomor dan email tersebut aktif untuk dihubungi oleh pihak sekolah.
                    </p>
                </div>
            @endif

        </div>
    </div>

    <style>
        @media print {
            body {
                background: white;
            }

            .print\\:hidden {
                display: none !important;
            }
        }
    </style>
</body>

</html>
