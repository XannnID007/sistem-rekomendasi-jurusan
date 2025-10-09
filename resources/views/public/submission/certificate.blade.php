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
    <style>
        @media print {
            body {
                background: white !important;
            }

            .print\\:hidden {
                display: none !important;
            }

            .no-print {
                display: none !important;
            }
        }

        /* Style mirip template PDF laporan */
        .certificate-container {
            border: 4px solid #1e3a8a;
            background: white;
        }

        .info-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }

        .info-row {
            display: flex;
            margin-bottom: 8px;
        }

        .info-label {
            font-weight: 600;
            width: 180px;
            color: #6b7280;
        }

        .info-value {
            flex: 1;
            color: #111827;
            font-weight: 500;
        }

        .result-box {
            border: 2px solid;
            background: linear-gradient(to right, #f1f5f9, #e2e8f0);
        }

        .badge {
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-tkj {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .badge-tkr {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-approved {
            background: #d1fae5;
            border: 2px solid #10b981;
            color: #047857;
        }

        .status-rejected {
            background: #fee2e2;
            border: 2px solid #ef4444;
            color: #991b1b;
        }

        .signature-line {
            border-top: 2px solid #111827;
            padding-top: 8px;
            margin-top: 80px;
            font-weight: 600;
        }
    </style>
</head>

<body class="bg-gray-100">

    <!-- Navigation (Hide on Print) -->
    <nav class="bg-white shadow-sm border-b border-gray-200 no-print">
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

            <!-- Success/Info Messages (Hide on Print) -->
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-lg no-print">
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
                <div class="bg-blue-50 border border-blue-200 text-blue-700 px-6 py-4 rounded-lg no-print">
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

            <!-- Action Buttons (Hide on Print) -->
            <div class="flex justify-end space-x-4 no-print">
                <button onclick="window.print()"
                    class="bg-navy text-white px-6 py-3 rounded-lg hover:bg-navy-dark transition font-semibold flex items-center space-x-2 shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    <span>Cetak</span>
                </button>
                <a href="{{ route('submission.download-pdf', $pesertaDidik->nisn) }}"
                    class="bg-gold text-navy px-6 py-3 rounded-lg hover:bg-gold-dark transition font-semibold flex items-center space-x-2 shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Download PDF</span>
                </a>
            </div>

            <!-- Certificate -->
            <div class="bg-white certificate-container rounded-xl shadow-xl p-8">

                <!-- Header - Style Laporan Admin -->
                <div class="text-center border-b-2 border-navy pb-6 mb-8">
                    <div class="w-20 h-20 bg-navy rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-10 h-10 text-gold" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-navy mb-2">SERTIFIKAT HASIL REKOMENDASI</h1>
                    <p class="text-lg text-gray-600">Sistem Pendukung Keputusan Pemilihan Jurusan</p>
                    <p class="text-sm text-gray-500 mt-2">SMK Penida 2 Katapang</p>
                    <p class="text-xs text-gray-400 mt-1">Jl. Raya Katapang No.123, Katapang, Kabupaten Bandung</p>
                </div>

                <!-- Data Peserta - Info Box Style -->
                <div class="info-box p-6 mb-6">
                    <h3 class="font-bold text-navy mb-4 text-lg">Data Peserta Didik</h3>
                    <div class="space-y-2">
                        <div class="info-row">
                            <span class="info-label">Nama Lengkap:</span>
                            <span class="info-value">{{ $pesertaDidik->nama_lengkap }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">NISN:</span>
                            <span class="info-value">{{ $pesertaDidik->nisn }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Jenis Kelamin:</span>
                            <span
                                class="info-value">{{ $pesertaDidik->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Tahun Ajaran:</span>
                            <span class="info-value">{{ $pesertaDidik->tahun_ajaran }}</span>
                        </div>
                    </div>
                </div>

                <!-- Hasil Rekomendasi - Result Box -->
                @php
                    $isTKJ = $perhitungan->jurusan_rekomendasi === 'TKJ';
                    $borderColor = $isTKJ ? '#3b82f6' : '#10b981';
                @endphp

                <div class="result-box rounded-xl p-8 text-center mb-6" style="border-color: {{ $borderColor }}">
                    <p class="text-sm text-gray-600 mb-2">Berdasarkan Metode TOPSIS, Anda Direkomendasikan:</p>
                    <h2 class="text-3xl font-bold text-navy mb-2">
                        {{ $isTKJ ? 'TEKNIK KOMPUTER DAN JARINGAN' : 'TEKNIK KENDARAAN RINGAN' }}
                    </h2>
                    <span class="badge {{ $isTKJ ? 'badge-tkj' : 'badge-tkr' }} text-xl">
                        {{ $perhitungan->jurusan_rekomendasi }}
                    </span>

                    <div class="grid grid-cols-2 gap-4 mt-6">
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <p class="text-xs text-gray-600 mb-1">Nilai Preferensi</p>
                            <p class="text-2xl font-bold text-navy">
                                {{ number_format($perhitungan->nilai_preferensi, 4) }}</p>
                        </div>
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <p class="text-xs text-gray-600 mb-1">Tingkat Kesesuaian</p>
                            <p class="text-2xl font-bold text-navy">
                                {{ number_format($perhitungan->nilai_preferensi * 100, 1) }}%</p>
                        </div>
                    </div>
                </div>

                <!-- Status Konfirmasi -->
                <div class="info-box p-6 mb-8">
                    <h3 class="font-bold text-navy mb-4">Status Konfirmasi</h3>

                    @if ($penilaian->status_submission === 'approved')
                        <div class="status-approved rounded-lg p-4">
                            <div class="flex items-center space-x-3 mb-2">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-bold text-lg">DISETUJUI</span>
                            </div>
                            <p class="text-sm">Peserta didik telah menyetujui rekomendasi ini</p>
                            <p class="text-xs mt-2 opacity-75">
                                Tanggal:
                                @if ($penilaian->tanggal_approved)
                                    @php
                                        $tanggalApproved =
                                            $penilaian->tanggal_approved instanceof \Carbon\Carbon
                                                ? $penilaian->tanggal_approved
                                                : \Carbon\Carbon::parse($penilaian->tanggal_approved);
                                    @endphp
                                    {{ $tanggalApproved->format('d F Y, H:i') }} WIB
                                @else
                                    {{ now()->format('d F Y, H:i') }} WIB
                                @endif
                            </p>
                        </div>
                    @elseif($penilaian->status_submission === 'rejected')
                        <div class="status-rejected rounded-lg p-4">
                            <div class="flex items-center space-x-3 mb-2">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-bold text-lg">TIDAK DISETUJUI</span>
                            </div>
                            <div class="bg-white rounded-lg p-4 mt-3 text-sm">
                                <div class="mb-2">
                                    <span class="text-gray-600">Jurusan yang Dipilih:</span>
                                    <p class="font-bold text-navy text-base">{{ $penilaian->jurusan_dipilih }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-600">Alasan:</span>
                                    <p class="text-gray-800">{{ $penilaian->alasan_penolakan }}</p>
                                </div>
                            </div>
                            <p class="text-xs mt-2 opacity-75">
                                Tanggal:
                                @if ($penilaian->tanggal_approved)
                                    @php
                                        $tanggalApproved =
                                            $penilaian->tanggal_approved instanceof \Carbon\Carbon
                                                ? $penilaian->tanggal_approved
                                                : \Carbon\Carbon::parse($penilaian->tanggal_approved);
                                    @endphp
                                    {{ $tanggalApproved->format('d F Y, H:i') }} WIB
                                @else
                                    {{ now()->format('d F Y, H:i') }} WIB
                                @endif
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Footer dengan Tanda Tangan -->
                <div class="border-t-2 border-gray-300 pt-8 mt-8">
                    <div class="grid grid-cols-2 gap-8 text-center">
                        <div>
                            <p class="text-sm text-gray-600 mb-2">Mengetahui,</p>
                            <p class="text-sm text-gray-600 mb-1">Kepala Sekolah</p>
                            <div class="signature-line inline-block px-8">
                                <p class="font-bold text-navy">Drs. H. Ahmad Suherman, M.Pd</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-2">Peserta Didik,</p>
                            <p class="text-sm text-gray-600 mb-1">&nbsp;</p>
                            <div class="signature-line inline-block px-8">
                                <p class="font-bold text-navy">{{ $pesertaDidik->nama_lengkap }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-8 text-xs text-gray-500 border-t border-gray-200 pt-6">
                        <p class="mb-1">Dokumen ini digenerate secara otomatis oleh Sistem Pendukung Keputusan</p>
                        <p class="font-semibold text-navy">SMK Penida 2 Katapang © {{ date('Y') }}</p>
                        <p class="mt-2 text-gray-400">Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB</p>
                    </div>
                </div>
            </div>

            <!-- Info Tambahan untuk Rejected (Hide on Print) -->
            @if ($penilaian->status_submission === 'rejected')
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 no-print">
                    <h4 class="font-bold text-blue-900 mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                        Informasi Penting
                    </h4>
                    <p class="text-sm text-blue-800 mb-3">
                        Karena Anda memilih jurusan yang berbeda dari rekomendasi sistem, admin sekolah akan menghubungi
                        Anda melalui:
                    </p>
                    <ul class="list-disc list-inside text-sm text-blue-800 space-y-1 ml-2">
                        <li><strong>Email:</strong> {{ $pesertaDidik->email_submission }}</li>
                        <li><strong>No. Telepon:</strong> {{ $pesertaDidik->no_telepon_submission }}</li>
                    </ul>
                    <p class="text-sm text-blue-800 mt-3 bg-blue-100 rounded p-2">
                        💡 <strong>Tips:</strong> Pastikan nomor dan email tersebut aktif untuk dihubungi oleh pihak
                        sekolah.
                    </p>
                </div>
            @endif

        </div>
    </div>

</body>

</html>
