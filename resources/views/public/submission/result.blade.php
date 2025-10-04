{{-- resources/views/public/submission/result.blade.php --}}
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
</head>

<body class="bg-gray-50">

    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-navy rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">SP</span>
                    </div>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">Hasil Rekomendasi Jurusan</h1>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto space-y-8">

            <!-- Header Hasil -->
            <div
                class="bg-gradient-to-r from-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-600 to-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-700 rounded-2xl p-8 text-white">
                <div class="text-center">
                    <div
                        class="w-20 h-20 bg-white bg-opacity-20 rounded-full mx-auto mb-6 flex items-center justify-center">
                        @if ($perhitungan->jurusan_rekomendasi === 'TKJ')
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                            </svg>
                        @else
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                                    clip-rule="evenodd" />
                            </svg>
                        @endif
                    </div>

                    <h1 class="text-3xl font-bold mb-2">Selamat, {{ $pesertaDidik->nama_lengkap }}!</h1>
                    <p class="text-xl mb-6">Hasil rekomendasi jurusan Anda adalah:</p>

                    <div class="bg-white bg-opacity-20 rounded-2xl p-6 mb-6">
                        <h2 class="text-4xl font-bold mb-2">
                            {{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'Teknik Komputer dan Jaringan' : 'Teknik Kendaraan Ringan' }}
                        </h2>
                        <p class="text-2xl">({{ $perhitungan->jurusan_rekomendasi }})</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white bg-opacity-10 rounded-xl p-4">
                            <p class="text-sm text-white text-opacity-80">Nilai Preferensi</p>
                            <p class="text-2xl font-bold">{{ number_format($perhitungan->nilai_preferensi, 4) }}</p>
                        </div>
                        <div class="bg-white bg-opacity-10 rounded-xl p-4">
                            <p class="text-sm text-white text-opacity-80">Tingkat Kesesuaian</p>
                            <p class="text-2xl font-bold">{{ number_format($perhitungan->nilai_preferensi * 100, 1) }}%
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Penjelasan Rekomendasi -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
                <h3 class="text-xl font-bold text-navy mb-4">📋 Penjelasan Rekomendasi</h3>
                <div class="space-y-4 text-gray-700">
                    @if ($perhitungan->jurusan_rekomendasi === 'TKJ')
                        <p>Berdasarkan analisis menggunakan metode TOPSIS dengan mempertimbangkan <strong>nilai
                                akademik</strong>, <strong>minat</strong>, <strong>keahlian</strong>, dan <strong>latar
                                belakang</strong> Anda, sistem merekomendasikan jurusan <strong>Teknik Komputer dan
                                Jaringan (TKJ)</strong>.</p>

                        <p>Nilai preferensi Anda <strong>{{ number_format($perhitungan->nilai_preferensi, 4) }}</strong>
                            berada di atas threshold 0.30, yang menunjukkan kesesuaian yang baik dengan jurusan TKJ.</p>

                        <div class="bg-blue-50 rounded-xl p-4 mt-4">
                            <h4 class="font-bold text-blue-900 mb-2">Tentang TKJ:</h4>
                            <p class="text-sm text-blue-800">TKJ adalah jurusan yang fokus pada teknologi informasi,
                                jaringan komputer, dan sistem informasi. Cocok untuk siswa yang memiliki minat tinggi
                                pada teknologi dan komputer.</p>
                        </div>
                    @else
                        <p>Berdasarkan analisis menggunakan metode TOPSIS dengan mempertimbangkan <strong>nilai
                                akademik</strong>, <strong>minat</strong>, <strong>keahlian</strong>, dan <strong>latar
                                belakang</strong> Anda, sistem merekomendasikan jurusan <strong>Teknik Kendaraan Ringan
                                (TKR)</strong>.</p>

                        <p>Nilai preferensi Anda <strong>{{ number_format($perhitungan->nilai_preferensi, 4) }}</strong>
                            berada di bawah atau sama dengan threshold 0.30, yang menunjukkan kesesuaian yang baik
                            dengan jurusan TKR.</p>

                        <div class="bg-green-50 rounded-xl p-4 mt-4">
                            <h4 class="font-bold text-green-900 mb-2">Tentang TKR:</h4>
                            <p class="text-sm text-green-800">TKR adalah jurusan yang fokus pada teknologi otomotif,
                                mesin kendaraan, dan sistem transportasi. Cocok untuk siswa yang memiliki minat pada
                                teknologi mekanik dan otomotif.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Konfirmasi Pilihan -->
            <div class="bg-yellow-50 border-2 border-yellow-200 rounded-2xl p-8">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Apakah Anda setuju dengan rekomendasi ini?</h3>
                    <p class="text-gray-600">Silakan pilih salah satu opsi di bawah ini</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tombol Setuju -->
                    <form action="{{ route('submission.approve', $pesertaDidik->nisn) }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin SETUJU dengan rekomendasi ini?')">
                        @csrf
                        <button type="submit"
                            class="w-full bg-green-600 text-white px-8 py-6 rounded-xl hover:bg-green-700 transition font-bold text-lg shadow-lg flex items-center justify-center space-x-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Ya, Saya Setuju</span>
                        </button>
                        <p class="text-sm text-gray-600 mt-2 text-center">Data akan tersimpan dan Anda bisa download
                            sertifikat</p>
                    </form>

                    <!-- Tombol Tidak Setuju -->
                    <button onclick="showRejectForm()"
                        class="w-full bg-red-600 text-white px-8 py-6 rounded-xl hover:bg-red-700 transition font-bold text-lg shadow-lg flex items-center justify-center space-x-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>Tidak, Saya Pilih Jurusan Lain</span>
                    </button>
                </div>
            </div>

            <!-- Form Penolakan (Hidden) -->
            <div id="rejectForm" class="hidden bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
                <h3 class="text-xl font-bold text-navy mb-6">Form Penolakan Rekomendasi</h3>

                <form action="{{ route('submission.reject', $pesertaDidik->nisn) }}" method="POST">
                    @csrf

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jurusan yang Anda Pilih <span
                                    class="text-red-500">*</span></label>
                            <select name="jurusan_dipilih" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy">
                                <option value="">Pilih Jurusan</option>
                                <option value="TKJ"
                                    {{ $perhitungan->jurusan_rekomendasi === 'TKR' ? 'selected' : '' }}>TKJ - Teknik
                                    Komputer dan Jaringan</option>
                                <option value="TKR"
                                    {{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'selected' : '' }}>TKR - Teknik
                                    Kendaraan Ringan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan <span
                                    class="text-red-500">*</span></label>
                            <textarea name="alasan_penolakan" rows="4" required minlength="10"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-navy"
                                placeholder="Jelaskan alasan Anda tidak setuju dengan rekomendasi (minimal 10 karakter)"></textarea>
                            <p class="mt-1 text-xs text-gray-500">Contoh: Saya lebih tertarik pada otomotif sejak kecil
                                dan sudah punya pengalaman di bengkel</p>
                        </div>

                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-sm text-yellow-800">
                                <strong>Catatan:</strong> Data Anda tetap akan tersimpan dan admin akan menghubungi Anda
                                untuk konfirmasi lebih lanjut mengenai pilihan jurusan.
                            </p>
                        </div>

                        <div class="flex space-x-4">
                            <button type="button" onclick="hideRejectForm()"
                                class="flex-1 bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition">
                                Batal
                            </button>
                            <button type="submit"
                                class="flex-1 bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition font-semibold">
                                Kirim Penolakan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        function showRejectForm() {
            document.getElementById('rejectForm').classList.remove('hidden');
            document.getElementById('rejectForm').scrollIntoView({
                behavior: 'smooth'
            });
        }

        function hideRejectForm() {
            document.getElementById('rejectForm').classList.add('hidden');
        }
    </script>
</body>

</html>
