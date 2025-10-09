<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Hasil Rekomendasi - {{ $pesertaDidik->nama_lengkap }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Tinos:wght@400;700&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Tinos', 'serif'],
                    },
                    colors: {
                        'navy': '#1e3a8a',
                        'navy-dark': '#1e40af',
                        'gold': '#ca8a04',
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

            .no-print {
                display: none !important;
            }
        }

        .certificate-body {
            border: 8px double #1e3a8a;
            background-color: #f8fafc;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto space-y-6">

            <div class="flex justify-between items-center no-print">
                <a href="{{ route('submission.result', ['nisn' => $pesertaDidik->nisn]) }}"
                    class="text-sm font-medium text-navy hover:underline">
                    &larr; Kembali ke Halaman Hasil
                </a>
                <div class="flex space-x-3">
                    <button onclick="window.print()"
                        class="bg-navy text-white px-5 py-2.5 rounded-lg hover:bg-navy-dark transition font-semibold flex items-center space-x-2 shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                            </path>
                        </svg>
                        <span>Cetak</span>
                    </button>
                    <a href="{{ route('submission.download-pdf', $pesertaDidik->nisn) }}"
                        class="bg-gold text-white px-5 py-2.5 rounded-lg hover:bg-yellow-600 transition font-semibold flex items-center space-x-2 shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        <span>Download PDF</span>
                    </a>
                </div>
            </div>

            <div class="bg-white certificate-body rounded-lg shadow-2xl p-8 md:p-12">

                <div class="flex items-center justify-between border-b-4 border-navy pb-6">
                    <div class="text-left">
                        <h1 class="text-3xl md:text-4xl font-extrabold text-navy font-serif tracking-wider">SERTIFIKAT
                            REKOMENDASI</h1>
                        <p class="text-lg text-gray-600 font-serif">Sistem Pendukung Keputusan Pemilihan Jurusan</p>
                    </div>
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Sekolah" class="w-24 h-24 object-contain">
                </div>

                <div class="mt-8">
                    <p class="text-gray-700 leading-relaxed text-center">Berdasarkan data penilaian dan analisis
                        menggunakan metode <strong>TOPSIS (Technique for Order of Preference by Similarity to Ideal
                            Solution)</strong>, dengan hormat menyatakan bahwa siswa berikut:</p>

                    <div class="my-6 bg-gray-50 border border-gray-200 rounded-lg p-6 text-base">
                        <div class="grid grid-cols-2 gap-x-8 gap-y-3">
                            <div class="font-semibold text-gray-500">Nama Lengkap</div>
                            <div class="font-semibold text-gray-900">: {{ $pesertaDidik->nama_lengkap }}</div>
                            <div class="font-semibold text-gray-500">NISN</div>
                            <div class="font-semibold text-gray-900">: {{ $pesertaDidik->nisn }}</div>
                            <div class="font-semibold text-gray-500">Tahun Ajaran</div>
                            <div class="font-semibold text-gray-900">: {{ $pesertaDidik->tahun_ajaran }}</div>
                        </div>
                    </div>

                    @php
                        $isTKJ = $perhitungan->jurusan_rekomendasi === 'TKJ';
                        $jurusanLengkap = $isTKJ ? 'Teknik Komputer & Jaringan' : 'Teknik Kendaraan Ringan';
                        $colorClass = $isTKJ ? 'blue' : 'green';
                    @endphp
                    <p class="text-gray-700 leading-relaxed text-center mb-6">Direkomendasikan untuk melanjutkan studi
                        ke jurusan:</p>
                    <div
                        class="bg-{{ $colorClass }}-50 border-2 border-{{ $colorClass }}-200 rounded-xl p-8 text-center">
                        <h2 class="text-4xl font-extrabold text-{{ $colorClass }}-800 font-serif tracking-wide">
                            {{ strtoupper($jurusanLengkap) }} ({{ $perhitungan->jurusan_rekomendasi }})</h2>
                        <div class="mt-4 text-sm text-{{ $colorClass }}-700">Dengan nilai preferensi sebesar <strong
                                class="text-lg">{{ number_format($perhitungan->nilai_preferensi, 4) }}</strong></div>
                    </div>

                    <div class="mt-6 text-center">
                        @if ($penilaian->status_submission === 'approved')
                            <p class="font-semibold text-green-700">Status: Telah Disetujui oleh Siswa</p>
                        @elseif($penilaian->status_submission === 'rejected')
                            <p class="font-semibold text-red-700">Status: Rekomendasi Ditolak, Siswa Memilih Jurusan
                                {{ $penilaian->jurusan_dipilih }}</p>
                        @endif
                    </div>
                </div>

                <div class="mt-16 flex justify-end">
                    <div class="text-center">
                        <p class="text-gray-700">Katapang, {{ now()->translatedFormat('d F Y') }}</p>
                        <p class="text-gray-700 mb-20">Kepala Sekolah SMK Penida 2 Katapang</p>
                        <p class="font-bold text-lg text-navy border-t-2 border-gray-800 pt-2">Drs. H. Ahmad Suherman,
                            M.Pd</p>
                    </div>
                </div>

            </div>
            @if ($penilaian->status_submission === 'rejected')
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 no-print">
                    <h4 class="font-bold text-blue-900 mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z">
                            </path>
                        </svg>
                        Informasi Penting
                    </h4>
                    <p class="text-sm text-blue-800 mb-3">
                        Karena Anda memilih jurusan yang berbeda, admin sekolah akan menghubungi Anda melalui:
                    </p>
                    <ul class="list-disc list-inside text-sm text-blue-800 space-y-1 ml-2">
                        <li><strong>Email:</strong> {{ $pesertaDidik->email_submission }}</li>
                        <li><strong>No. Telepon:</strong> {{ $pesertaDidik->no_telepon_submission }}</li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
</body>

</html>
