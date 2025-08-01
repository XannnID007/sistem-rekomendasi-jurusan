@extends('layouts.student')

@section('title', 'Perhitungan TOPSIS')
@section('page-title', 'Detail Perhitungan TOPSIS')
@section('page-description', 'Proses perhitungan lengkap metode TOPSIS untuk rekomendasi jurusan')

@section('content')
    <div class="space-y-6">
        <!-- Header Summary -->
        <div class="bg-gradient-to-r from-navy to-navy-dark rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Perhitungan TOPSIS Lengkap</h2>
                    <p class="text-blue-100">Analisis step-by-step untuk {{ $pesertaDidik->nama_lengkap }}</p>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-gold">{{ number_format($perhitungan->nilai_preferensi, 4) }}</div>
                    <div class="text-sm text-blue-100">Nilai Preferensi</div>
                </div>
            </div>
        </div>

        <!-- Step 1: Decision Matrix -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-navy">Langkah 1: Matriks Keputusan</h3>
                <p class="text-sm text-gray-600 mt-1">Data mentah dari semua siswa (disamarkan untuk privasi)</p>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-2 px-3 font-medium text-gray-700">Siswa</th>
                                @foreach (['N1', 'N2', 'N3', 'N4', 'N5', 'N6', 'MA', 'MB', 'MC', 'MD', 'BB', 'BP'] as $criteria)
                                    <th class="text-center py-2 px-2 font-medium text-gray-700">{{ $criteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topsisSteps['decision_matrix'] as $row)
                                <tr
                                    class="border-b border-gray-100 {{ strpos($row['student'], 'Anda') !== false ? 'bg-blue-50' : '' }}">
                                    <td
                                        class="py-2 px-3 font-medium {{ strpos($row['student'], 'Anda') !== false ? 'text-blue-700' : 'text-gray-900' }}">
                                        {{ $row['student'] }}
                                    </td>
                                    @foreach ($row['values'] as $value)
                                        <td class="text-center py-2 px-2">{{ $value }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm text-blue-700">
                        <strong>Penjelasan:</strong> Matriks ini berisi data mentah dari semua siswa.
                        Baris yang disorot adalah data Anda. Data lain disamarkan untuk menjaga privasi.
                    </p>
                </div>
            </div>
        </div>

        <!-- Step 2: Normalized Matrix -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-navy">Langkah 2: Normalisasi Matriks</h3>
                <p class="text-sm text-gray-600 mt-1">{{ $topsisSteps['normalized_matrix']['explanation'] }}</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach ($topsisSteps['normalized_matrix']['your_values'] as $index => $value)
                        @php
                            $criteria = ['N1', 'N2', 'N3', 'N4', 'N5', 'N6', 'MA', 'MB', 'MC', 'MD', 'BB', 'BP'];
                            $criteriaName = $criteria[$index] ?? 'C' . ($index + 1);
                        @endphp
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <div class="text-xs text-gray-600 mb-1">{{ $criteriaName }}</div>
                            <div class="text-sm font-mono font-medium">{{ number_format($value, 6) }}</div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-sm text-green-700">
                        <strong>Rumus:</strong> r<sub>ij</sub> = x<sub>ij</sub> / √(Σx<sub>kj</sub>²)
                        <br>Setiap nilai dibagi dengan akar kuadrat dari jumlah kuadrat semua nilai pada kolom yang sama.
                    </p>
                </div>
            </div>
        </div>

        <!-- Step 3: Weighted Matrix -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-navy">Langkah 3: Matriks Terbobot</h3>
                <p class="text-sm text-gray-600 mt-1">{{ $topsisSteps['weighted_matrix']['explanation'] }}</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Bobot Kriteria -->
                    <div>
                        <h4 class="font-medium text-gray-900 mb-3">Bobot Kriteria</h4>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach ($topsisSteps['weighted_matrix']['weights'] as $index => $weight)
                                @php
                                    $criteria = [
                                        'N1',
                                        'N2',
                                        'N3',
                                        'N4',
                                        'N5',
                                        'N6',
                                        'MA',
                                        'MB',
                                        'MC',
                                        'MD',
                                        'BB',
                                        'BP',
                                    ];
                                    $criteriaName = $criteria[$index] ?? 'C' . ($index + 1);
                                @endphp
                                <div class="flex justify-between text-sm">
                                    <span>{{ $criteriaName }}:</span>
                                    <span class="font-medium">{{ number_format($weight, 4) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Nilai Terbobot Anda -->
                    <div>
                        <h4 class="font-medium text-gray-900 mb-3">Nilai Terbobot Anda</h4>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach ($topsisSteps['weighted_matrix']['your_values'] as $index => $value)
                                @php
                                    $criteria = [
                                        'N1',
                                        'N2',
                                        'N3',
                                        'N4',
                                        'N5',
                                        'N6',
                                        'MA',
                                        'MB',
                                        'MC',
                                        'MD',
                                        'BB',
                                        'BP',
                                    ];
                                    $criteriaName = $criteria[$index] ?? 'C' . ($index + 1);
                                @endphp
                                <div class="flex justify-between text-sm">
                                    <span>{{ $criteriaName }}:</span>
                                    <span class="font-mono">{{ number_format($value, 6) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="p-3 bg-purple-50 border border-purple-200 rounded-lg">
                    <p class="text-sm text-purple-700">
                        <strong>Rumus:</strong> v<sub>ij</sub> = w<sub>j</sub> × r<sub>ij</sub>
                        <br>Nilai ternormalisasi dikalikan dengan bobot masing-masing kriteria.
                    </p>
                </div>
            </div>
        </div>

        <!-- Step 4: Ideal Solutions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-navy">Langkah 4: Solusi Ideal dan Jarak</h3>
                <p class="text-sm text-gray-600 mt-1">{{ $topsisSteps['ideal_solutions']['explanation'] }}</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-4 bg-green-50 rounded-lg">
                        <h4 class="font-medium text-green-800 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Jarak ke Solusi Ideal Positif (D⁺)
                        </h4>
                        <div class="text-2xl font-bold text-green-600 mb-2">
                            {{ number_format($topsisSteps['ideal_solutions']['distances']['positive'], 6) }}
                        </div>
                        <p class="text-sm text-green-700">
                            Jarak Euclidean ke titik terbaik yang mungkin. Semakin kecil semakin baik.
                        </p>
                    </div>

                    <div class="p-4 bg-red-50 rounded-lg">
                        <h4 class="font-medium text-red-800 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Jarak ke Solusi Ideal Negatif (D⁻)
                        </h4>
                        <div class="text-2xl font-bold text-red-600 mb-2">
                            {{ number_format($topsisSteps['ideal_solutions']['distances']['negative'], 6) }}
                        </div>
                        <p class="text-sm text-red-700">
                            Jarak Euclidean ke titik terburuk yang mungkin. Semakin besar semakin baik.
                        </p>
                    </div>
                </div>

                <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-sm text-yellow-700">
                        <strong>Rumus Jarak:</strong> d = √(Σ(v<sub>i</sub> - v<sub>ideal</sub>)²)
                        <br>Menggunakan rumus jarak Euclidean untuk mengukur kedekatan dengan solusi ideal.
                    </p>
                </div>
            </div>
        </div>

        <!-- Step 5: Preference Score -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-navy">Langkah 5: Nilai Preferensi dan Rekomendasi</h3>
                <p class="text-sm text-gray-600 mt-1">Perhitungan final untuk menentukan rekomendasi jurusan</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-6 bg-navy-50 rounded-lg">
                        <h4 class="font-medium text-navy mb-3">Perhitungan Nilai Preferensi</h4>
                        <div class="space-y-3">
                            <div class="text-sm">
                                <span class="text-gray-600">Rumus:</span>
                                <span
                                    class="font-mono bg-white px-2 py-1 rounded border ml-2">{{ $topsisSteps['preference_score']['formula'] }}</span>
                            </div>
                            <div class="text-sm">
                                <span class="text-gray-600">Perhitungan:</span>
                                <div class="font-mono bg-white px-2 py-1 rounded border mt-1 text-xs">
                                    {{ $topsisSteps['preference_score']['calculation'] }}
                                </div>
                            </div>
                            <div class="pt-3 border-t border-gray-200">
                                <div class="text-lg font-medium text-gray-700">Nilai Preferensi:</div>
                                <div class="text-3xl font-bold text-navy">
                                    {{ number_format($topsisSteps['preference_score']['score'], 4) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-50 rounded-lg">
                        <h4
                            class="font-medium text-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-800 mb-3">
                            Rekomendasi Jurusan</h4>
                        <div class="text-center">
                            <div
                                class="w-16 h-16 bg-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                @if ($perhitungan->jurusan_rekomendasi === 'TKJ')
                                    <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                                    </svg>
                                @else
                                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </div>
                            <div
                                class="text-3xl font-bold text-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-600 mb-2">
                                {{ $perhitungan->jurusan_rekomendasi }}
                            </div>
                            <div
                                class="text-sm text-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-700">
                                {{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'Teknik Komputer dan Jaringan' : 'Teknik Kendaraan Ringan' }}
                            </div>
                            <div
                                class="mt-3 pt-3 border-t border-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-200">
                                <p
                                    class="text-xs text-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-600">
                                    {{ $perhitungan->nilai_preferensi > 0.3 ? 'Nilai > 0.30 → TKJ' : 'Nilai ≤ 0.30 → TKR' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                    <h4 class="font-medium text-gray-900 mb-2">Interpretasi Hasil</h4>
                    <div class="text-sm text-gray-700 space-y-1">
                        <p>• Nilai preferensi berkisar antara 0 hingga 1</p>
                        <p>• Semakin tinggi nilai preferensi, semakin dekat dengan solusi ideal positif</p>
                        <p>• Threshold 0.30 digunakan untuk membedakan rekomendasi TKJ dan TKR</p>
                        <p>• Nilai Anda: <strong>{{ number_format($perhitungan->nilai_preferensi, 4) }}</strong>
                            ({{ $perhitungan->nilai_preferensi > 0.3 ? 'Di atas' : 'Di bawah atau sama dengan' }}
                            threshold)</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Card -->
        <div
            class="bg-gradient-to-r from-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-50 to-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-100 rounded-xl p-6 border border-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-200">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-600"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3
                        class="text-xl font-bold text-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-800 mb-2">
                        Perhitungan TOPSIS Selesai!
                    </h3>
                    <p class="text-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-700">
                        Berdasarkan analisis komprehensif menggunakan 12 kriteria, sistem merekomendasikan jurusan
                        <strong>{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'Teknik Komputer dan Jaringan (TKJ)' : 'Teknik Kendaraan Ringan (TKR)' }}</strong>
                        untuk Anda dengan nilai preferensi
                        <strong>{{ number_format($perhitungan->nilai_preferensi, 4) }}</strong>.
                    </p>
                </div>
            </div>
        </div>

        <!-- Navigation Links -->
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('student.analisis.index') }}"
                class="flex-1 bg-navy text-white px-6 py-3 rounded-lg hover:bg-navy-dark transition duration-200 text-center font-medium">
                Kembali ke Analisis
            </a>
            <a href="{{ route('student.analisis.kriteria') }}"
                class="flex-1 bg-white border border-navy text-navy px-6 py-3 rounded-lg hover:bg-navy hover:text-white transition duration-200 text-center font-medium">
                Lihat Detail Kriteria
            </a>
            <a href="{{ route('student.rekomendasi.index') }}"
                class="flex-1 bg-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-600 text-white px-6 py-3 rounded-lg hover:bg-{{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-700 transition duration-200 text-center font-medium">
                Lihat Rekomendasi Lengkap
            </a>
        </div>
    </div>

    @push('scripts')
        <script>
            // Add interactive tooltips or additional functionality here
            console.log('TOPSIS Detail page loaded');
            document.querySelectorAll('.text-mono').forEach(el => {
                el.addEventListener('click', () => {
                    navigator.clipboard.writeText(el.textContent);
                    alert('Nilai telah disalin ke clipboard!');
                });
            });
        </script>
    @endpush
@endsection
