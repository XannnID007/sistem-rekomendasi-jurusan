@extends('layouts.admin')

@section('title', 'Hitung TOPSIS')
@section('page-title', 'Perhitungan TOPSIS')
@section('page-description', 'Pilih peserta didik untuk dihitung menggunakan metode TOPSIS')

@section('content')
    <div class="space-y-6">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Total Siswa</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $totalBelumDihitung + $totalSudahDihitung }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if ($totalBelumDihitung > 0)
            <!-- Bulk Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                    <div>
                        <h3 class="text-lg font-semibold text-navy">Aksi Cepat</h3>
                        <p class="text-sm text-gray-600 mt-1">Hitung TOPSIS untuk semua peserta didik sekaligus</p>
                    </div>
                    <form method="POST" action="{{ route('admin.perhitungan.calculate-all') }}" class="inline"
                        onsubmit="return confirm('Yakin ingin menghitung TOPSIS untuk semua peserta didik yang belum dihitung?')">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-navy text-white rounded-lg hover:bg-navy-dark transition duration-200 font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            Hitung Semua ({{ $totalBelumDihitung }} siswa)
                        </button>
                    </form>
                </div>
            </div>

            <!-- Individual Selection -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-navy">Pilih Peserta Didik</h3>
                        <div class="flex items-center space-x-3">
                            <button type="button" onclick="selectAll()"
                                class="text-sm text-navy hover:text-navy-dark font-medium">
                                Pilih Semua
                            </button>
                            <button type="button" onclick="deselectAll()"
                                class="text-sm text-gray-500 hover:text-gray-700 font-medium">
                                Batal Pilih
                            </button>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">Pilih peserta didik yang akan dihitung TOPSIS</p>
                </div>

                <form method="POST" action="{{ route('admin.perhitungan.calculate') }}" id="calculateForm">
                    @csrf
                    <div class="p-6">
                        @if ($pesertaDidik->count() > 0)
                            <div class="space-y-4">
                                @foreach ($pesertaDidik as $pd)
                                    <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                                        <input type="checkbox" name="peserta_didik_ids[]"
                                            value="{{ $pd->peserta_didik_id }}" id="pd_{{ $pd->peserta_didik_id }}"
                                            class="h-4 w-4 text-navy focus:ring-navy border-gray-300 rounded">
                                        <label for="pd_{{ $pd->peserta_didik_id }}" class="ml-4 flex-1 cursor-pointer">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-4">
                                                    <div
                                                        class="w-10 h-10 bg-navy rounded-full flex items-center justify-center">
                                                        <span
                                                            class="text-white font-bold text-sm">{{ substr($pd->nama_lengkap, 0, 1) }}</span>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-gray-900">{{ $pd->nama_lengkap }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">NISN: {{ $pd->nisn }} •
                                                            {{ $pd->tahun_ajaran }}</div>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    @if ($pd->penilaianTerbaru)
                                                        <div class="text-sm text-gray-900">
                                                            Rata-rata:
                                                            {{ number_format($pd->penilaianTerbaru->rata_nilai_akademik, 1) }}
                                                        </div>
                                                        <div class="text-xs text-gray-500">
                                                            {{ $pd->penilaianTerbaru->sudah_dihitung ? 'Perlu dihitung ulang' : 'Belum dihitung' }}
                                                        </div>
                                                    @else
                                                        <div class="text-sm text-red-600">Tidak ada penilaian</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <div class="flex justify-between items-center">
                                    <div class="text-sm text-gray-600">
                                        <span id="selectedCount">0</span> peserta didik dipilih
                                    </div>
                                    <div class="flex space-x-3">
                                        <a href="{{ route('admin.perhitungan.index') }}"
                                            class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                                            Batal
                                        </a>
                                        <button type="submit" id="calculateBtn"
                                            class="px-6 py-2 bg-navy text-white rounded-lg hover:bg-navy-dark transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                            disabled>
                                            Hitung TOPSIS
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Data</h3>
                                <p class="text-gray-600 mb-4">
                                    Semua peserta didik sudah dihitung atau belum ada data penilaian yang tersedia.
                                </p>
                                <a href="{{ route('admin.peserta-didik.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy-dark transition duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Kelola Peserta Didik
                                </a>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        @else
            <!-- No Data to Calculate -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Semua Data Sudah Dihitung</h3>
                <p class="text-gray-600 mb-6">
                    Semua peserta didik yang memiliki data penilaian sudah dihitung menggunakan metode TOPSIS.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('admin.perhitungan.index') }}"
                        class="inline-flex items-center px-6 py-3 bg-navy text-white rounded-lg hover:bg-navy-dark transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 00-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Lihat Hasil Perhitungan
                    </a>
                    <a href="{{ route('admin.peserta-didik.index') }}"
                        class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Data Penilaian
                    </a>
                </div>
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
                        <p>• Metode TOPSIS menggunakan 12 kriteria untuk menentukan rekomendasi jurusan</p>
                        <p>• Sistem akan menghitung jarak ke solusi ideal positif dan negatif</p>
                        <p>• Hasil berupa nilai preferensi (0-1) dan rekomendasi jurusan (TKJ/TKR)</p>
                        <p>• Threshold: > 0.30 = TKJ, ≤ 0.30 = TKR</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function selectAll() {
                const checkboxes = document.querySelectorAll('input[name="peserta_didik_ids[]"]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = true;
                });
                updateSelectedCount();
            }

            function deselectAll() {
                const checkboxes = document.querySelectorAll('input[name="peserta_didik_ids[]"]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
                updateSelectedCount();
            }

            function updateSelectedCount() {
                const checkboxes = document.querySelectorAll('input[name="peserta_didik_ids[]"]:checked');
                const count = checkboxes.length;
                const selectedCount = document.getElementById('selectedCount');
                const calculateBtn = document.getElementById('calculateBtn');

                if (selectedCount) {
                    selectedCount.textContent = count;
                }

                if (calculateBtn) {
                    calculateBtn.disabled = count === 0;
                }
            }

            // Add event listeners to checkboxes
            document.addEventListener('DOMContentLoaded', function() {
                const checkboxes = document.querySelectorAll('input[name="peserta_didik_ids[]"]');
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', updateSelectedCount);
                });

                // Initial count update
                updateSelectedCount();
            });

            // Form submission confirmation
            document.getElementById('calculateForm')?.addEventListener('submit', function(e) {
                const checkboxes = document.querySelectorAll('input[name="peserta_didik_ids[]"]:checked');
                if (checkboxes.length === 0) {
                    e.preventDefault();
                    alert('Pilih minimal satu peserta didik untuk dihitung.');
                    return;
                }

                const confirmed = confirm(
                    `Yakin ingin menghitung TOPSIS untuk ${checkboxes.length} peserta didik yang dipilih?`);
                if (!confirmed) {
                    e.preventDefault();
                }
            });
        </script>
    @endpush

@endsection
