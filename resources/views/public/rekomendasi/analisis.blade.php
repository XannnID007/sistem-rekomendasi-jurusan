<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Perhitungan TOPSIS - {{ $pesertaDidik->nama_lengkap }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
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
            animation: fadeIn 0.6s ease-out forwards;
            opacity: 0;
            transform: translateY(10px);
        }

        .fade-in-delay-1 {
            animation-delay: 0.1s;
        }

        .fade-in-delay-2 {
            animation-delay: 0.2s;
        }

        .fade-in-delay-3 {
            animation-delay: 0.3s;
        }

        .fade-in-delay-4 {
            animation-delay: 0.4s;
        }

        .fade-in-delay-5 {
            animation-delay: 0.5s;
        }

        @keyframes fadeIn {
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

<body class="bg-gray-50 font-sans">
    <nav class="bg-white/80 backdrop-blur-lg shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <img src="/images/logo.png" alt="Logo SPK" class="w-10 h-10 object-contain"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="w-10 h-10 bg-navy rounded-lg flex items-center justify-center" style="display: none;">
                        <span class="text-white font-semibold text-lg">SP</span>
                    </div>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">Detail Perhitungan TOPSIS</h1>
                        <p class="text-xs text-gray-500">{{ $pesertaDidik->nama_lengkap }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('rekomendasi.show', $pesertaDidik->nisn) }}"
                        class="text-navy hover:text-navy-dark text-sm font-medium">
                        ← Kembali ke Hasil
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto space-y-8">

            <div class="text-center fade-in">
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Detail Proses Perhitungan TOPSIS</h1>
                <p class="mt-2 text-lg text-gray-600">Memahami bagaimana sistem memberikan rekomendasi untuk Anda.</p>
            </div>

            <div class="space-y-8">

                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 fade-in fade-in-delay-1">
                    <div class="flex items-center space-x-4 mb-6">
                        <div
                            class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center border-2 border-gray-200">
                            <span class="text-navy font-bold text-xl">1</span>
                        </div>
                        <h3 class="text-2xl font-bold text-navy">Kriteria & Bobot</h3>
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
                                            {{ number_format($k->bobot, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 fade-in fade-in-delay-2">
                        <div class="flex items-center space-x-4 mb-6">
                            <div
                                class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center border-2 border-gray-200">
                                <span class="text-navy font-bold text-xl">2</span>
                            </div>
                            <h3 class="text-2xl font-bold text-navy">Normalisasi</h3>
                        </div>
                        <div class="space-y-3">
                            @foreach ($kriteria as $k)
                                @php
                                    $normalizedField = 'normalized_' . strtolower($k->kode_kriteria);
                                    $normalizedValue = $perhitungan->$normalizedField ?? 0;
                                @endphp
                                <div class="flex justify-between items-center text-sm p-2 bg-gray-50 rounded-md">
                                    <span class="text-gray-600">{{ $k->kode_kriteria }} - {{ $k->nama_kriteria }}</span>
                                    <span class="font-bold text-navy">{{ number_format($normalizedValue, 6) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 fade-in fade-in-delay-3">
                        <div class="flex items-center space-x-4 mb-6">
                            <div
                                class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center border-2 border-gray-200">
                                <span class="text-navy font-bold text-xl">3</span>
                            </div>
                            <h3 class="text-2xl font-bold text-navy">Pembobotan</h3>
                        </div>
                        <div class="space-y-3">
                            @foreach ($kriteria as $k)
                                @php
                                    $weightedField = 'weighted_' . strtolower($k->kode_kriteria);
                                    $weightedValue = $perhitungan->$weightedField ?? 0;
                                @endphp
                                <div class="flex justify-between items-center text-sm p-2 bg-gray-50 rounded-md">
                                    <span class="text-gray-600">{{ $k->kode_kriteria }} (Bobot:
                                        {{ $k->bobot }})</span>
                                    <span class="font-bold text-navy">{{ number_format($weightedValue, 6) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 fade-in fade-in-delay-4">
                        <div class="flex items-center space-x-4 mb-6">
                            <div
                                class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center border-2 border-gray-200">
                                <span class="text-navy font-bold text-xl">4</span>
                            </div>
                            <h3 class="text-2xl font-bold text-navy">Jarak Solusi Ideal</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="bg-green-50 border border-green-200 rounded-xl p-6 text-center">
                                <h4 class="font-bold text-green-800 mb-2">Jarak ke Solusi Ideal Positif (D⁺)</h4>
                                <div class="text-4xl font-extrabold text-green-600">
                                    {{ number_format($perhitungan->jarak_positif, 4) }}</div>
                                <p class="text-xs text-green-700 mt-1">Semakin kecil, semakin baik</p>
                            </div>
                            <div class="bg-red-50 border border-red-200 rounded-xl p-6 text-center">
                                <h4 class="font-bold text-red-800 mb-2">Jarak ke Solusi Ideal Negatif (D⁻)</h4>
                                <div class="text-4xl font-extrabold text-red-600">
                                    {{ number_format($perhitungan->jarak_negatif, 4) }}</div>
                                <p class="text-xs text-red-700 mt-1">Semakin besar, semakin baik</p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-navy rounded-2xl shadow-lg p-8 text-white flex flex-col justify-center items-center fade-in fade-in-delay-5">
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold text-xl">5</span>
                            </div>
                            <h3 class="text-2xl font-bold">Hasil Akhir</h3>
                        </div>
                        <div class="text-center">
                            <p class="text-base text-white/80">Nilai Preferensi (V)</p>
                            <p class="text-7xl font-extrabold my-2 tracking-tight">
                                {{ number_format($perhitungan->nilai_preferensi, 4) }}</p>
                            <p class="text-base text-white/80">Rekomendasi:</p>
                            <p class="text-2xl font-bold mt-1">{{ $perhitungan->jurusan_rekomendasi }}</p>
                        </div>
                        <div class="mt-6 text-center text-sm bg-black/20 p-3 rounded-lg">
                            <p><strong>Formula:</strong> V = D⁻ / (D⁺ + D⁻)</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 fade-in">
                <a href="{{ route('rekomendasi.detail', $pesertaDidik->nisn) }}"
                    class="bg-white border-2 border-navy text-navy px-6 py-4 rounded-xl hover:bg-navy hover:text-white transition text-center font-bold text-lg flex items-center justify-center gap-2">
                    <span>🔬</span>
                    <span>Kembali ke Analisis</span>
                </a>
                <a href="{{ route('rekomendasi.index') }}"
                    class="bg-gray-200 text-gray-800 px-6 py-4 rounded-xl hover:bg-gray-300 transition text-center font-bold text-lg flex items-center justify-center gap-2">
                    <span>🔍</span>
                    <span>Cari NISN Lain</span>
                </a>
            </div>

        </div>
    </div>

    <footer class="bg-white border-t border-gray-200 py-6 mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-600">
            <p>&copy; {{ date('Y') }} SMK Penida 2 Katapang. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
