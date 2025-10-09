<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Rekomendasi - SPK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'navy': '#1e3a8a',
                        'navy-dark': '#1e40af',
                        'gold': '#fbbf24',
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .fade-in-delay {
            animation: fadeIn 0.5s ease-out 0.2s forwards;
            opacity: 0;
        }
    </style>
</head>

<body class="bg-gray-100">

    <nav class="bg-white shadow-sm">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <img src="/images/logo.png" alt="Logo SPK" class="w-10 h-10 object-contain"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="w-10 h-10 bg-navy rounded-lg flex items-center justify-center" style="display: none;">
                        <span class="text-white font-semibold text-lg">SP</span>
                    </div>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">SPK Pemilihan Jurusan</h1>
                        <p class="text-xs text-gray-500">SMK Penida 2 Katapang</p>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto space-y-6">

            @if (isset($error))
                <div class="bg-white rounded-xl shadow-md p-8 text-center fade-in">
                    <svg class="animate-spin h-12 w-12 text-navy mx-auto mb-4" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Sedang Memproses Rekomendasi...</h3>
                    <p class="text-gray-600">{{ $error }}</p>
                </div>
            @elseif($perhitungan)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden fade-in">
                    <div class="p-8">
                        <p class="text-gray-600">Selamat, {{ $pesertaDidik->nama_lengkap }}!</p>
                        <h1 class="text-3xl font-bold text-gray-900 mt-1">Ini Hasil Rekomendasi Untukmu</h1>
                    </div>

                    @php
                        $isTKJ = $perhitungan->jurusan_rekomendasi === 'TKJ';
                        $bgColor = $isTKJ ? 'bg-blue-600' : 'bg-green-600';
                        $textColor = $isTKJ ? 'text-blue-900' : 'text-green-900';
                        $ringColor = $isTKJ ? 'ring-blue-100' : 'ring-green-100';
                    @endphp

                    <div class="px-8 pb-8">
                        <div
                            class="rounded-xl p-6 {{ $bgColor }} text-white text-center ring-4 ring-opacity-50 {{ $ringColor }}">
                            <p class="text-sm font-medium opacity-80">Rekomendasi Jurusan</p>
                            <h2 class="text-4xl font-bold mt-2">
                                {{ $isTKJ ? 'Teknik Komputer & Jaringan' : 'Teknik Kendaraan Ringan' }}
                            </h2>
                            <p class="text-2xl font-semibold opacity-90">({{ $perhitungan->jurusan_rekomendasi }})</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-4 text-center">
                            <div class="bg-gray-100 rounded-lg p-4">
                                <p class="text-sm text-gray-600">Nilai Preferensi</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ number_format($perhitungan->nilai_preferensi, 4) }}</p>
                            </div>
                            <div class="bg-gray-100 rounded-lg p-4">
                                <p class="text-sm text-gray-600">Tingkat Kesesuaian</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ number_format($perhitungan->nilai_preferensi * 100, 1) }}%</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-8 text-center fade-in-delay">
                    <h3 class="text-xl font-bold text-gray-900">Konfirmasi Pilihan Anda</h3>
                    <p class="text-gray-600 mt-2">Apakah Anda setuju dengan rekomendasi jurusan di atas?</p>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <form action="{{ route('submission.approve', $pesertaDidik->nisn) }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin SETUJU dengan rekomendasi ini?')">
                            @csrf
                            <button type="submit"
                                class="w-full bg-green-600 text-white px-6 py-4 rounded-lg hover:bg-green-700 transition-colors font-bold text-lg shadow-sm flex items-center justify-center space-x-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Ya, Saya Setuju</span>
                            </button>
                        </form>

                        <button onclick="showRejectForm()"
                            class="w-full bg-gray-200 text-gray-800 px-6 py-4 rounded-lg hover:bg-gray-300 transition-colors font-bold text-lg flex items-center justify-center space-x-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span>Tidak, Pilih Jurusan Lain</span>
                        </button>
                    </div>
                </div>

                <div id="rejectForm" class="hidden bg-white rounded-2xl shadow-lg p-8 fade-in">
                    <h3 class="text-xl font-bold text-navy mb-6 text-center">Formulir Pilihan Berbeda</h3>
                    <form action="{{ route('submission.reject', $pesertaDidik->nisn) }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jurusan yang Anda Pilih
                                    <span class="text-red-500">*</span></label>
                                <select name="jurusan_dipilih" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy">
                                    <option value="">Pilih Jurusan</option>
                                    <option value="TKJ" {{ !$isTKJ ? 'selected' : '' }}>TKJ - Teknik Komputer dan
                                        Jaringan</option>
                                    <option value="TKR" {{ $isTKJ ? 'selected' : '' }}>TKR - Teknik Kendaraan Ringan
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Anda <span
                                        class="text-red-500">*</span></label>
                                <textarea name="alasan_penolakan" rows="4" required minlength="10"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy"
                                    placeholder="Contoh: Saya lebih tertarik pada otomotif sejak kecil..."></textarea>
                            </div>
                            <div class="flex space-x-4">
                                <button type="button" onclick="hideRejectForm()"
                                    class="w-full bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 transition font-semibold">Batal</button>
                                <button type="submit"
                                    class="w-full bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition font-semibold">Kirim
                                    Pilihan</button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif

        </div>
    </div>

    <script>
        function showRejectForm() {
            const rejectForm = document.getElementById('rejectForm');
            rejectForm.classList.remove('hidden');
            rejectForm.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }

        function hideRejectForm() {
            document.getElementById('rejectForm').classList.add('hidden');
        }

        @if (isset($error))
            setTimeout(() => location.reload(), 3000);
        @endif
    </script>
</body>

</html>
