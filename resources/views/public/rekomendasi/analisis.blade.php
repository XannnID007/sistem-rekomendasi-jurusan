<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Perhitungan TOPSIS - {{ $pesertaDidik->nama_lengkap }}</title>
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
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

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

        table {
            font-size: 0.875rem;
        }

        th,
        td {
            padding: 0.75rem 0.5rem;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-navy rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">SP</span>
                    </div>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">SPK Pemilihan Jurusan</h1>
                        <p class="text-xs text-gray-500">Detail Perhitungan TOPSIS</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('rekomendasi.show', $pesertaDidik->nisn) }}"
                        class="text-navy hover:text-navy-dark text-sm font-medium">
                        ← Kembali
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-8">

            <!-- Header -->
            <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-2xl p-8 text-white fade-in">
                <h1 class="text-3xl font-bold mb-2">Detail Perhitungan TOPSIS</h1>
                <p class="text-xl text-white text-opacity-90">{{ $pesertaDidik->nama_lengkap }} - NISN:
                    {{ $pesertaDidik->nisn }}</p>
                <div class="mt-4 flex items-center space-x-6">
                    <div class="bg-white bg-opacity-20 rounded-xl px-6 py-3">
                        <p class="text-sm text-white text-opacity-80">Hasil Akhir</p>
                        <p class="text-2xl font-bold">{{ $perhitungan->jurusan_rekomendasi }}</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-xl px-6 py-3">
                        <p class="text-sm text-white text-opacity-80">Nilai Preferensi</p>
                        <p class="text-2xl font-bold">{{ number_format($perhitungan->nilai_preferensi, 4) }}</p>
                    </div>
                </div>
            </div>

            <!-- Overview -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 fade-in">
                <h3 class="text-xl font-bold text-navy mb-4">📋 Ringkasan Proses</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-blue-50 rounded-xl">
                        <div class="text-3xl font-bold text-blue-600">{{ $processOverview['total_criteria'] }}</div>
                        <div class="text-sm text-gray-600 mt-1">Total Kriteria</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-xl">
                        <div class="text-3xl font-bold text-green-600">{{ $processOverview['threshold'] }}</div>
                        <div class="text-sm text-gray-600 mt-1">Threshold</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-xl">
                        <div class="text-3xl font-bold text-purple-600">
                            {{ number_format($processOverview['preference_score'], 3) }}</div>
                        <div class="text-sm text-gray-600 mt-1">Skor Akhir</div>
                    </div>
                    <div class="text-center p-4 bg-yellow-50 rounded-xl">
                        <div class="text-2xl font-bold text-yellow-600">{{ $processOverview['recommendation'] }}</div>
                        <div class="text-sm text-gray-600 mt-1">Rekomendasi</div>
                    </div>
                </div>
            </div>

            <!-- Tahapan TOPSIS -->
            <div class="space-y-6">

                <!-- Tahap 1: Data Kriteria -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 fade-in">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                            <span class="text-blue-600 font-bold text-lg">1</span>
                        </div>
                        <h3 class="text-xl font-bold text-navy">Data Kriteria dan Bobot</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                                    <th class="text-left text-xs font-medium text-gray-500 uppercase">Nama Kriteria</th>
                                    <th class="text-center text-xs font-medium text-gray-500 uppercase">Jenis</th>
                                    <th class="text-center text-xs font-medium text-gray-500 uppercase">Bobot</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($kriteria as $k)
                                    <tr class="hover:bg-gray-50">
                                        <td class="font-medium text-gray-900">{{ $k->kode_kriteria }}</td>
                                        <td class="text-gray-700">{{ $k->nama_kriteria }}</td>
                                        <td class="text-center">
                                            <span
                                                class="px-2 py-1 text-xs rounded-full {{ $k->jenis_kriteria === 'benefit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($k->jenis_kriteria) }}
                                            </span>
                                        </td>
                                        <td class="text-center font-medium text-gray-900">
                                            {{ number_format($k->bobot, 4) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tahap 2: Matriks Keputusan -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 fade-in">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                            <span class="text-green-600 font-bold text-lg">2</span>
                        </div>
                        <h3 class="text-xl font-bold text-navy">Matriks Keputusan (Data Anda)</h3>
                    </div>

                    <p class="text-sm text-gray-600 mb-4">Nilai yang digunakan dalam perhitungan (data pribadi Anda)</p>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left text-xs font-medium text-gray-500 uppercase">Kriteria</th>
                                    @foreach ($kriteria as $k)
                                        <th class="text-center text-xs font-medium text-gray-500 uppercase">
                                            {{ $k->kode_kriteria }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <tr class="bg-blue-50">
                                    <td class="font-medium text-gray-900">Nilai Anda</td>
                                    @foreach ($kriteria as $k)
                                        @php
                                            $kode = strtolower($k->kode_kriteria);
                                            $nilai = 0;
                                            if (strpos($kode, 'n') === 0) {
                                                $nilai = $perhitungan->penilaian->{'nilai_akademik'}[$kode] ?? 0;
                                            } elseif (strpos($kode, 'm') === 0) {
                                                $minatKey = str_replace('m', '', $kode);
                                                $minatVal = $perhitungan->penilaian->{'minat_' . $minatKey};
                                                $nilai = $perhitungan->penilaian->convertMinatToNumeric($minatVal);
                                            } elseif ($kode === 'bb') {
                                                $nilai = $perhitungan->penilaian->convertKeahlianToNumeric(
                                                    $perhitungan->penilaian->keahlian,
                                                );
                                            } elseif ($kode === 'bp') {
                                                $nilai = $perhitungan->penilaian->convertPenghasilanToNumeric(
                                                    $perhitungan->penilaian->penghasilan_ortu,
                                                );
                                            }
                                        @endphp
                                        <td class="text-center font-medium text-blue-700">{{ $nilai }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tahap 3: Normalisasi -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 fade-in">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                            <span class="text-purple-600 font-bold text-lg">3</span>
                        </div>
                        <h3 class="text-xl font-bold text-navy">Matriks Ternormalisasi</h3>
                    </div>

                    <div class="bg-purple-50 border border-purple-200 rounded-xl p-4 mb-4">
                        <p class="text-sm text-purple-800">
                            <strong>Rumus:</strong> r<sub>ij</sub> = x<sub>ij</sub> / √(Σx<sub>ij</sub>²)
                        </p>
                        <p class="text-xs text-purple-700 mt-1">Setiap nilai dibagi dengan akar kuadrat dari jumlah
                            kuadrat semua nilai pada kolom yang sama</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                                    @foreach ($kriteria as $k)
                                        <th class="text-center text-xs font-medium text-gray-500 uppercase">
                                            {{ $k->kode_kriteria }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <tr class="bg-purple-50">
                                    <td class="font-medium text-gray-900">Nilai Ternormalisasi</td>
                                    @foreach ($kriteria as $k)
                                        @php
                                            $kode = strtolower($k->kode_kriteria);
                                            $fieldName = 'normalized_' . $kode;
                                            $nilai = $perhitungan->{$fieldName} ?? 0;
                                        @endphp
                                        <td class="text-center font-medium text-purple-700">
                                            {{ number_format($nilai, 6) }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tahap 4: Pembobotan -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 fade-in">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center">
                            <span class="text-yellow-600 font-bold text-lg">4</span>
                        </div>
                        <h3 class="text-xl font-bold text-navy">Matriks Ternormalisasi Terbobot</h3>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-4">
                        <p class="text-sm text-yellow-800">
                            <strong>Rumus:</strong> y<sub>ij</sub> = w<sub>j</sub> × r<sub>ij</sub>
                        </p>
                        <p class="text-xs text-yellow-700 mt-1">Nilai ternormalisasi dikalikan dengan bobot
                            masing-masing kriteria</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                                    @foreach ($kriteria as $k)
                                        <th class="text-center text-xs font-medium text-gray-500 uppercase">
                                            {{ $k->kode_kriteria }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <tr class="bg-yellow-50">
                                    <td class="font-medium text-gray-900">Nilai Terbobot</td>
                                    @foreach ($kriteria as $k)
                                        @php
                                            $kode = strtolower($k->kode_kriteria);
                                            $fieldName = 'weighted_' . $kode;
                                            $nilai = $perhitungan->{$fieldName} ?? 0;
                                        @endphp
                                        <td class="text-center font-medium text-yellow-700">
                                            {{ number_format($nilai, 6) }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tahap 5: Solusi Ideal -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 fade-in">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                            <span class="text-red-600 font-bold text-lg">5</span>
                        </div>
                        <h3 class="text-xl font-bold text-navy">Perhitungan Jarak ke Solusi Ideal</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                            <h4 class="font-bold text-green-800 mb-3">Jarak ke Solusi Ideal Positif (D⁺)</h4>
                            <div class="text-3xl font-bold text-green-600 mb-2">
                                {{ number_format($perhitungan->jarak_positif, 6) }}</div>
                            <p class="text-sm text-green-700">Semakin kecil nilai D⁺, semakin baik</p>
                        </div>

                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                            <h4 class="font-bold text-blue-800 mb-3">Jarak ke Solusi Ideal Negatif (D⁻)</h4>
                            <div class="text-3xl font-bold text-blue-600 mb-2">
                                {{ number_format($perhitungan->jarak_negatif, 6) }}</div>
                            <p class="text-sm text-blue-700">Semakin besar nilai D⁻, semakin baik</p>
                        </div>
                    </div>

                    <div class="mt-6 bg-gray-50 rounded-xl p-4">
                        <p class="text-sm text-gray-700">
                            <strong>Rumus:</strong><br>
                            D⁺ = √[Σ(y<sub>ij</sub> - y<sub>j</sub>⁺)²]<br>
                            D⁻ = √[Σ(y<sub>ij</sub> - y<sub>j</sub>⁻)²]
                        </p>
                    </div>
                </div>

                <!-- Tahap 6: Nilai Preferensi -->
                <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-2xl shadow-lg p-8 text-white fade-in">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold text-lg">6</span>
                        </div>
                        <h3 class="text-xl font-bold">Hasil Akhir: Nilai Preferensi</h3>
                    </div>

                    <div class="bg-white bg-opacity-10 rounded-xl p-6 mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                            <div>
                                <p class="text-sm text-white text-opacity-80 mb-2">Nilai Preferensi (V)</p>
                                <p class="text-4xl font-bold">{{ number_format($perhitungan->nilai_preferensi, 4) }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-white text-opacity-80 mb-2">Persentase</p>
                                <p class="text-4xl font-bold">
                                    {{ number_format($perhitungan->nilai_preferensi * 100, 2) }}%</p>
                            </div>
                            <div>
                                <p class="text-sm text-white text-opacity-80 mb-2">Rekomendasi</p>
                                <p class="text-4xl font-bold">{{ $perhitungan->jurusan_rekomendasi }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white bg-opacity-10 rounded-xl p-4">
                        <p class="text-sm mb-2"><strong>Rumus:</strong> V = D⁻ / (D⁺ + D⁻)</p>
                        <p class="text-sm mb-2">
                            V = {{ number_format($perhitungan->jarak_negatif, 6) }} /
                            ({{ number_format($perhitungan->jarak_positif, 6) }} +
                            {{ number_format($perhitungan->jarak_negatif, 6) }})
                        </p>
                        <p class="text-sm">V = {{ number_format($perhitungan->nilai_preferensi, 6) }}</p>
                        <div class="mt-4 pt-4 border-t border-white border-opacity-20">
                            <p class="text-sm font-bold">Interpretasi:</p>
                            <p class="text-sm">
                                @if ($perhitungan->nilai_preferensi > 0.3)
                                    Nilai preferensi > 0.30 → Direkomendasikan <strong>TKJ (Teknik Komputer dan
                                        Jaringan)</strong>
                                @else
                                    Nilai preferensi ≤ 0.30 → Direkomendasikan <strong>TKR (Teknik Kendaraan
                                        Ringan)</strong>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Penjelasan Metode -->
            <div class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-8 fade-in">
                <h3 class="text-xl font-bold text-navy mb-4">📚 Tentang Metode TOPSIS</h3>
                <div class="space-y-3 text-sm text-blue-900">
                    <p><strong>TOPSIS (Technique for Order of Preference by Similarity to Ideal Solution)</strong>
                        adalah metode pengambilan keputusan multikriteria yang digunakan untuk menentukan alternatif
                        terbaik berdasarkan jarak terdekat dari solusi ideal positif dan terjauh dari solusi ideal
                        negatif.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div class="bg-white rounded-xl p-4">
                            <h4 class="font-bold text-blue-800 mb-2">Kelebihan TOPSIS:</h4>
                            <ul class="space-y-1 text-xs">
                                <li>✓ Konsep sederhana dan mudah dipahami</li>
                                <li>✓ Efisien secara komputasi</li>
                                <li>✓ Mampu mengukur kinerja relatif</li>
                                <li>✓ Mempertimbangkan kriteria benefit dan cost</li>
                            </ul>
                        </div>

                        <div class="bg-white rounded-xl p-4">
                            <h4 class="font-bold text-blue-800 mb-2">Langkah-langkah:</h4>
                            <ul class="space-y-1 text-xs">
                                <li>1. Membuat matriks keputusan</li>
                                <li>2. Normalisasi matriks</li>
                                <li>3. Pembobotan matriks ternormalisasi</li>
                                <li>4. Menentukan solusi ideal</li>
                                <li>5. Menghitung jarak</li>
                                <li>6. Menghitung nilai preferensi</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 fade-in">
                <a href="{{ route('rekomendasi.show', $pesertaDidik->nisn) }}"
                    class="bg-navy text-white px-6 py-4 rounded-xl hover:bg-navy-dark transition text-center font-semibold">
                    ← Hasil Rekomendasi
                </a>
                <a href="{{ route('rekomendasi.detail', $pesertaDidik->nisn) }}"
                    class="bg-white border-2 border-navy text-navy px-6 py-4 rounded-xl hover:bg-navy hover:text-white transition text-center font-semibold">
                    📊 Analisis Lengkap
                </a>
                <a href="{{ route('rekomendasi.index') }}"
                    class="bg-gray-500 text-white px-6 py-4 rounded-xl hover:bg-gray-600 transition text-center font-semibold">
                    🔍 Cari NISN Lain
                </a>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-600">
            <p>&copy; 2024 SMK Penida 2 Katapang. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
