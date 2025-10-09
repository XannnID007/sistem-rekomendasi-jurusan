@extends('layouts.admin')

@section('title', 'Hitung TOPSIS')
@section('page-title', 'Perhitungan TOPSIS')
@section('page-description', 'Lakukan perhitungan TOPSIS untuk rekomendasi jurusan')

@section('content')
    <div class="space-y-6">
        <!-- Criteria Validation Check -->
        @if (!$criteriaInfo['is_valid'])
            <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-red-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    <div>
                        <h4 class="font-medium text-red-800 mb-1">Peringatan: Bobot Kriteria Tidak Valid</h4>
                        <p class="text-sm text-red-700 mb-3">
                            Total bobot kriteria saat ini: {{ number_format($criteriaInfo['total_weight'] * 100, 2) }}%.
                            Total bobot harus sama dengan 100% (1.0) untuk perhitungan TOPSIS yang akurat.
                        </p>
                        <a href="{{ route('admin.kriteria.index') }}"
                            class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700">
                            Perbaiki Bobot Kriteria
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Belum Dihitung</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $totalBelumDihitung }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Sudah Dihitung</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $totalSudahDihitung }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Total Kriteria</p>
                        <p class="text-lg font-semibold text-gray-900">{{ count($criteriaInfo['criteria']) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Total Bobot</p>
                        <p
                            class="text-lg font-semibold {{ $criteriaInfo['is_valid'] ? 'text-green-600' : 'text-red-600' }}">
                            {{ number_format($criteriaInfo['total_weight'] * 100, 1) }}%</p>
                    </div>
                </div>
            </div>
        </div>

        @if ($totalBelumDihitung > 0 && $criteriaInfo['is_valid'])
            <!-- Individual Selection -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-navy">Pilih Peserta Didik untuk Dihitung</h3>
                    <p class="text-sm text-gray-600 mt-1">Pilih peserta didik yang akan dihitung menggunakan metode TOPSIS
                    </p>
                </div>

                <form method="POST" action="{{ route('admin.perhitungan.calculate') }}" id="calculate-form">
                    @csrf
                    <div class="p-6">
                        <div class="mb-4 flex justify-between items-center">
                            <div class="flex items-center space-x-4">
                                <button type="button" id="select-all"
                                    class="text-sm text-navy hover:text-navy-dark font-medium">
                                    Pilih Semua
                                </button>
                                <button type="button" id="deselect-all"
                                    class="text-sm text-gray-600 hover:text-gray-800 font-medium">
                                    Batal Pilih Semua
                                </button>
                                <span id="selected-count" class="text-sm text-gray-500">0 dipilih</span>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left">
                                            <input type="checkbox" id="check-all"
                                                class="rounded border-gray-300 text-navy focus:ring-navy">
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Peserta Didik
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tahun Ajaran
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status Data
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Rata-rata Nilai
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($pesertaDidik as $pd)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="checkbox" name="peserta_didik_ids[]"
                                                    value="{{ $pd->peserta_didik_id }}"
                                                    class="student-checkbox rounded border-gray-300 text-navy focus:ring-navy">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div
                                                        class="w-10 h-10 bg-navy rounded-full flex items-center justify-center">
                                                        <span
                                                            class="text-white font-bold text-sm">{{ substr($pd->nama_lengkap, 0, 1) }}</span>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $pd->nama_lengkap }}</div>
                                                        <div class="text-sm text-gray-500">NISN: {{ $pd->nisn }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $pd->tahun_ajaran }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($pd->penilaianTerbaru && $pd->penilaianTerbaru->isReadyForCalculation())
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Lengkap
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Tidak Lengkap
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if ($pd->penilaianTerbaru)
                                                    {{ number_format($pd->penilaianTerbaru->rata_rata_nilai_akademik, 1) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-8 text-center">
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    <p class="text-gray-500 text-lg">Tidak ada data yang perlu dihitung</p>
                                                    <p class="text-gray-400 text-sm mt-1">Semua peserta didik sudah
                                                        dihitung
                                                        atau data belum lengkap</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($pesertaDidik->count() > 0)
                            <div class="mt-6 flex justify-between items-center">
                                <div class="text-sm text-gray-600">
                                    <span id="selection-info">Pilih peserta didik yang akan dihitung</span>
                                </div>
                                <div class="flex space-x-3">
                                    <button type="submit" id="calculate-selected"
                                        class="px-6 py-2 bg-navy text-white rounded-lg hover:bg-navy-dark transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                        disabled>
                                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        Hitung Terpilih
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        @endif

        <!-- Information Card -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
            <div class="flex items-start space-x-3">
                <svg class="w-6 h-6 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h4 class="font-medium text-blue-800 mb-2">Informasi Perhitungan TOPSIS</h4>
                    <div class="text-sm text-blue-700 space-y-2">
                        <p>• <strong>Metode TOPSIS</strong> menggunakan 12 kriteria untuk menentukan rekomendasi jurusan
                            yang optimal.</p>
                        <p>• <strong>Threshold = 0.30:</strong> Nilai preferensi > 0.30 akan direkomendasikan untuk TKJ,
                            sedangkan ≤ 0.30 untuk TKR.</p>
                        <p>• Pastikan semua <strong>bobot kriteria</strong> sudah benar dan total bobotnya = 100% sebelum
                            melakukan perhitungan.</p>
                        <p>• Data penilaian harus <strong>lengkap</strong> (nilai akademik, minat, keahlian, dan
                            biaya gelombang) untuk dapat dihitung.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Debug Information (hanya untuk development) -->
        @if (config('app.debug'))
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-6">
                <h4 class="font-medium text-gray-800 mb-3">Debug Information</h4>
                <div class="text-xs text-gray-600 space-y-1">
                    <p><strong>Total Criteria:</strong> {{ count($criteriaInfo['criteria']) }}</p>
                    <p><strong>Total Weight:</strong> {{ $criteriaInfo['total_weight'] }}</p>
                    <p><strong>Weight Valid:</strong> {{ $criteriaInfo['is_valid'] ? 'Yes' : 'No' }}</p>
                    <p><strong>Ready for Calculation:</strong> {{ $totalBelumDihitung }}</p>
                    <p><strong>Already Calculated:</strong> {{ $totalSudahDihitung }}</p>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const checkAll = document.getElementById('check-all');
                const selectAll = document.getElementById('select-all');
                const deselectAll = document.getElementById('deselect-all');
                const studentCheckboxes = document.querySelectorAll('.student-checkbox');
                const selectedCount = document.getElementById('selected-count');
                const calculateButton = document.getElementById('calculate-selected');
                const selectionInfo = document.getElementById('selection-info');

                function updateUI() {
                    const checkedBoxes = document.querySelectorAll('.student-checkbox:checked');
                    const count = checkedBoxes.length;

                    selectedCount.textContent = count + ' dipilih';

                    if (count > 0) {
                        calculateButton.disabled = false;
                        calculateButton.classList.remove('opacity-50', 'cursor-not-allowed');
                        selectionInfo.textContent = count + ' peserta didik akan dihitung';
                    } else {
                        calculateButton.disabled = true;
                        calculateButton.classList.add('opacity-50', 'cursor-not-allowed');
                        selectionInfo.textContent = 'Pilih peserta didik yang akan dihitung';
                    }

                    // Update check-all state
                    if (count === studentCheckboxes.length && count > 0) {
                        checkAll.checked = true;
                        checkAll.indeterminate = false;
                    } else if (count > 0) {
                        checkAll.checked = false;
                        checkAll.indeterminate = true;
                    } else {
                        checkAll.checked = false;
                        checkAll.indeterminate = false;
                    }
                }

                // Check all functionality
                checkAll.addEventListener('change', function() {
                    studentCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateUI();
                });

                // Select all button
                selectAll.addEventListener('click', function() {
                    studentCheckboxes.forEach(checkbox => {
                        checkbox.checked = true;
                    });
                    updateUI();
                });

                // Deselect all button
                deselectAll.addEventListener('click', function() {
                    studentCheckboxes.forEach(checkbox => {
                        checkbox.checked = false;
                    });
                    updateUI();
                });

                // Individual checkbox change
                studentCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', updateUI);
                });

                // Initialize UI
                updateUI();

                // Form submission confirmation
                document.getElementById('calculate-form').addEventListener('submit', function(e) {
                    const checkedBoxes = document.querySelectorAll('.student-checkbox:checked');
                    if (checkedBoxes.length === 0) {
                        e.preventDefault();
                        alert('Pilih minimal satu peserta didik untuk dihitung.');
                        return false;
                    }

                    const confirmMessage =
                        `Yakin ingin menghitung TOPSIS untuk ${checkedBoxes.length} peserta didik yang dipilih?`;
                    if (!confirm(confirmMessage)) {
                        e.preventDefault();
                        return false;
                    }

                    // Show loading state
                    calculateButton.disabled = true;
                    calculateButton.innerHTML = `
                        <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Sedang Menghitung...
                    `;
                });
            });
        </script>
    @endpush

@endsection
