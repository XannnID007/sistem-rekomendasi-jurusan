@extends('layouts.admin')

@section('title', 'Buat Laporan')
@section('page-title', 'Buat Laporan Baru')
@section('page-description', 'Generate laporan sistem pendukung keputusan')

@push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="space-y-6">
        <!-- Laporan Types -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Individual Report Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-navy">Laporan Individual</h3>
                        <p class="text-sm text-gray-500">Per siswa spesifik</p>
                    </div>
                </div>
                <p class="text-gray-600 mb-4">Generate laporan detail untuk siswa tertentu dengan analisis TOPSIS lengkap.
                </p>
                <button onclick="openModal('individual')"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                    Buat Laporan Individual
                </button>
            </div>

            <!-- Summary Report Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 00-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-navy">Laporan Ringkasan</h3>
                        <p class="text-sm text-gray-500">Overview keseluruhan</p>
                    </div>
                </div>
                <p class="text-gray-600 mb-4">Generate ringkasan statistik untuk semua siswa dalam periode tertentu.</p>
                <button onclick="openModal('summary')"
                    class="w-full bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200 px-4 py-2">
                    Buat Laporan Ringkasan
                </button>
            </div>

            <!-- Comparison Report Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-navy">Laporan Perbandingan</h3>
                        <p class="text-sm text-gray-500">Antar periode</p>
                    </div>
                </div>
                <p class="text-gray-600 mb-4">Generate perbandingan data dan tren antar tahun ajaran atau periode tertentu.
                </p>
                <button onclick="openModal('comparison')"
                    class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition duration-200">
                    Buat Laporan Perbandingan
                </button>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-navy">Filter Rekomendasi</h3>
                        <p class="text-sm text-gray-500">TKJ atau TKR saja</p>
                    </div>
                </div>
                <p class="text-gray-600 mb-4">Generate laporan khusus siswa dengan rekomendasi TKJ atau TKR saja.</p>
                <button onclick="openModal('recommendation_filter')"
                    class="w-full bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition duration-200">
                    Buat Laporan Filter
                </button>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-navy mb-4">Data Tersedia</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600 mb-1">{{ $totalPesertaDidik }}</div>
                    <div class="text-sm text-gray-600">Total Peserta Didik</div>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <div class="text-2xl font-bold text-green-600 mb-1">{{ $totalPerhitungan }}</div>
                    <div class="text-sm text-gray-600">Total Perhitungan</div>
                </div>
                <div class="text-center p-4 bg-purple-50 rounded-lg">
                    <div class="text-2xl font-bold text-purple-600 mb-1">{{ $tahunAjaran->count() }}</div>
                    <div class="text-sm text-gray-600">Tahun Ajaran</div>
                </div>
                <div class="text-center p-4 bg-yellow-50 rounded-lg">
                    <div class="text-2xl font-bold text-yellow-600 mb-1">12</div>
                    <div class="text-sm text-gray-600">Kriteria TOPSIS</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Individual Report Modal -->
    <div id="individualModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl max-w-2xl w-full p-6 max-h-screen overflow-y-auto">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-navy">Buat Laporan Individual</h3>
                    <button onclick="closeModal('individual')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.laporan.generate.individual') }}"
                    onsubmit="return validateIndividualForm()">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="individual_tahun_ajaran" class="block text-sm font-medium text-gray-700 mb-2">
                                Tahun Ajaran <span class="text-red-500">*</span>
                            </label>
                            <select name="tahun_ajaran" id="individual_tahun_ajaran" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent">
                                <option value="">Pilih Tahun Ajaran</option>
                                @foreach ($tahunAjaran as $tahun)
                                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Data siswa akan dimuat setelah memilih tahun ajaran</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Pilih Peserta Didik <span class="text-red-500">*</span>
                            </label>
                            <div class="border border-gray-300 rounded-lg">
                                <div class="max-h-64 overflow-y-auto p-3" id="studentsList">
                                    <p class="text-gray-500 text-sm">Pilih tahun ajaran terlebih dahulu</p>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Hanya siswa yang sudah memiliki perhitungan TOPSIS yang
                                dapat dipilih</p>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeModal('individual')"
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-200">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Generate Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Summary Report Modal -->
    <div id="summaryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl max-w-lg w-full p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-navy">Buat Laporan Ringkasan</h3>
                    <button onclick="closeModal('summary')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.laporan.generate.summary') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="summary_tahun_ajaran" class="block text-sm font-medium text-gray-700 mb-2">
                                Tahun Ajaran <span class="text-red-500">*</span>
                            </label>
                            <select name="tahun_ajaran" id="summary_tahun_ajaran" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent">
                                <option value="">Pilih Tahun Ajaran</option>
                                @foreach ($tahunAjaran as $tahun)
                                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Opsi Tambahan</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="include_charts" value="1"
                                        class="rounded border-gray-300 text-navy focus:ring-navy">
                                    <span class="ml-2 text-sm text-gray-700">Sertakan grafik dan chart</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="include_statistics" value="1" checked
                                        class="rounded border-gray-300 text-navy focus:ring-navy">
                                    <span class="ml-2 text-sm text-gray-700">Sertakan statistik detail</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeModal('summary')"
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-200">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                            Generate Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Comparison Report Modal -->
    <div id="comparisonModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl max-w-lg w-full p-6 max-h-screen overflow-y-auto">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-navy">Buat Laporan Perbandingan</h3>
                    <button onclick="closeModal('comparison')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.laporan.generate.comparison') }}" id="comparisonForm">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Pilih Tahun Ajaran untuk Dibandingkan <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-2 max-h-32 overflow-y-auto border border-gray-300 rounded-lg p-3"
                                id="tahunAjaranList">
                                @if ($tahunAjaran->count() > 0)
                                    @foreach ($tahunAjaran as $tahun)
                                        <label class="flex items-center">
                                            <input type="checkbox" name="tahun_ajaran[]" value="{{ $tahun }}"
                                                class="rounded border-gray-300 text-navy focus:ring-navy tahun-checkbox">
                                            <span class="ml-2 text-sm text-gray-700">{{ $tahun }}</span>
                                        </label>
                                    @endforeach
                                @else
                                    <p class="text-sm text-gray-500">Tidak ada tahun ajaran tersedia</p>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Pilih minimal 2 tahun ajaran</p>
                            <div id="tahunAjaranError" class="text-red-500 text-xs mt-1 hidden">
                                Pilih minimal 2 tahun ajaran untuk perbandingan
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Kriteria Perbandingan <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="comparison_criteria[]" value="total_siswa" checked
                                        class="rounded border-gray-300 text-navy focus:ring-navy criteria-checkbox">
                                    <span class="ml-2 text-sm text-gray-700">Total siswa</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="comparison_criteria[]" value="rekomendasi_jurusan"
                                        checked
                                        class="rounded border-gray-300 text-navy focus:ring-navy criteria-checkbox">
                                    <span class="ml-2 text-sm text-gray-700">Distribusi rekomendasi jurusan</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="comparison_criteria[]" value="nilai_preferensi"
                                        class="rounded border-gray-300 text-navy focus:ring-navy criteria-checkbox">
                                    <span class="ml-2 text-sm text-gray-700">Nilai preferensi rata-rata</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="comparison_criteria[]" value="gender_distribution"
                                        class="rounded border-gray-300 text-navy focus:ring-navy criteria-checkbox">
                                    <span class="ml-2 text-sm text-gray-700">Distribusi gender</span>
                                </label>
                            </div>
                            <div id="criteriaError" class="text-red-500 text-xs mt-1 hidden">
                                Pilih minimal satu kriteria perbandingan
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeModal('comparison')"
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-200">
                            Batal
                        </button>
                        <button type="submit" id="submitComparison"
                            class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-200">
                            Generate Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="recommendation_filterModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl max-w-lg w-full p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-navy">Laporan Filter Rekomendasi</h3>
                    <button onclick="closeModal('recommendation_filter')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.laporan.generate.recommendation') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="recommendation_tahun_ajaran" class="block text-sm font-medium text-gray-700 mb-2">
                                Tahun Ajaran <span class="text-red-500">*</span>
                            </label>
                            <select name="tahun_ajaran" id="recommendation_tahun_ajaran" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent">
                                <option value="">Pilih Tahun Ajaran</option>
                                @foreach ($tahunAjaran as $tahun)
                                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="jurusan_filter" class="block text-sm font-medium text-gray-700 mb-2">
                                Filter Rekomendasi <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-2">
                                <label
                                    class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                    <input type="radio" name="jurusan_filter" value="TKJ" required
                                        class="mr-3 text-navy focus:ring-navy">
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-900">TKJ (Teknik Komputer dan Jaringan)</div>
                                        <div class="text-sm text-gray-500">Hanya siswa yang direkomendasikan TKJ</div>
                                    </div>
                                </label>
                                <label
                                    class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                    <input type="radio" name="jurusan_filter" value="TKR" required
                                        class="mr-3 text-navy focus:ring-navy">
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-900">TKR (Teknik Kendaraan Ringan)</div>
                                        <div class="text-sm text-gray-500">Hanya siswa yang direkomendasikan TKR</div>
                                    </div>
                                </label>
                                <label
                                    class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                    <input type="radio" name="jurusan_filter" value="all"
                                        class="mr-3 text-navy focus:ring-navy">
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-900">Semua Rekomendasi</div>
                                        <div class="text-sm text-gray-500">Siswa TKJ dan TKR</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Opsi Tambahan</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="include_charts" value="1"
                                        class="rounded border-gray-300 text-navy focus:ring-navy">
                                    <span class="ml-2 text-sm text-gray-700">Sertakan grafik dan chart</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="include_statistics" value="1" checked
                                        class="rounded border-gray-300 text-navy focus:ring-navy">
                                    <span class="ml-2 text-sm text-gray-700">Sertakan statistik detail</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeModal('recommendation_filter')"
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-200">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition duration-200">
                            Generate Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            // Modal functions
            function openModal(type) {
                document.getElementById(type + 'Modal').classList.remove('hidden');

                // Reset form validation when opening comparison modal
                if (type === 'comparison') {
                    document.getElementById('tahunAjaranError').classList.add('hidden');
                    document.getElementById('criteriaError').classList.add('hidden');
                }
            }

            function closeModal(type) {
                document.getElementById(type + 'Modal').classList.add('hidden');

                // Reset students list when closing individual modal
                if (type === 'individual') {
                    const studentsList = document.getElementById('studentsList');
                    if (studentsList) {
                        studentsList.innerHTML = '<p class="text-gray-500 text-sm">Pilih tahun ajaran terlebih dahulu</p>';
                    }
                    // Reset tahun ajaran dropdown
                    const tahunAjaranSelect = document.getElementById('individual_tahun_ajaran');
                    if (tahunAjaranSelect) {
                        tahunAjaranSelect.value = '';
                    }
                }
            }

            // Form validation for individual report
            function validateIndividualForm() {
                const tahunAjaran = document.getElementById('individual_tahun_ajaran').value;
                const selectedStudents = document.querySelectorAll('input[name="peserta_didik_ids[]"]:checked');

                if (!tahunAjaran) {
                    alert('Pilih tahun ajaran terlebih dahulu');
                    return false;
                }

                if (selectedStudents.length === 0) {
                    alert('Pilih minimal satu peserta didik');
                    return false;
                }

                return true;
            }

            console.log('Base URL:', window.location.origin);
            console.log('Current URL:', window.location.href);

            // Load students when academic year is selected for individual report
            document.addEventListener('DOMContentLoaded', function() {
                const tahunAjaranSelect = document.getElementById('individual_tahun_ajaran');

                if (tahunAjaranSelect) {
                    tahunAjaranSelect.addEventListener('change', function() {
                        const tahunAjaran = this.value;
                        const studentsList = document.getElementById('studentsList');

                        console.log('Tahun ajaran selected:', tahunAjaran);

                        if (!tahunAjaran) {
                            studentsList.innerHTML =
                                '<p class="text-gray-500 text-sm">Pilih tahun ajaran terlebih dahulu</p>';
                            return;
                        }

                        // Show loading state
                        studentsList.innerHTML = `
                <div class="flex items-center justify-center py-4">
                    <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-navy"></div>
                    <div class="text-gray-500 text-sm ml-2">Loading siswa...</div>
                </div>
            `;

                        // PERBAIKAN URL - Gunakan route helper Laravel
                        const url = "{{ route('admin.laporan.get-students') }}" + "?tahun_ajaran=" +
                            encodeURIComponent(tahunAjaran);

                        console.log('Request URL:', url);

                        // Make AJAX call to get students
                        fetch(url, {
                                method: 'GET',
                                headers: {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        ?.getAttribute('content') || ''
                                },
                                credentials: 'same-origin'
                            })
                            .then(response => {
                                console.log('Response status:', response.status);
                                console.log('Response URL:', response.url);

                                if (!response.ok) {
                                    throw new Error(
                                        `HTTP error! status: ${response.status} - ${response.statusText}`
                                    );
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log('Response data:', data);

                                if (data.error) {
                                    throw new Error(data.error);
                                }

                                if (data.students && data.students.length > 0) {
                                    let html = '<div class="space-y-2">';
                                    data.students.forEach(student => {
                                        html += `
                            <label class="flex items-center p-2 hover:bg-gray-50 rounded">
                                <input type="checkbox" name="peserta_didik_ids[]" value="${student.id}" 
                                       class="rounded border-gray-300 text-navy focus:ring-navy mr-3">
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-gray-900">${student.nama}</div>
                                    <div class="text-xs text-gray-500">
                                        NISN: ${student.nisn} | ${student.jenis_kelamin}
                                    </div>
                                    <div class="text-xs text-blue-600">
                                        Rekomendasi: ${student.rekomendasi} (${student.nilai_preferensi})
                                    </div>
                                </div>
                            </label>
                        `;
                                    });
                                    html += '</div>';

                                    // Add select all checkbox
                                    const selectAllHtml = `
                        <div class="border-b border-gray-200 pb-2 mb-2">
                            <label class="flex items-center">
                                <input type="checkbox" id="selectAllStudents" 
                                       class="rounded border-gray-300 text-navy focus:ring-navy mr-2">
                                <span class="text-sm font-medium text-gray-700">Pilih Semua (${data.students.length} siswa)</span>
                            </label>
                        </div>
                    `;

                                    studentsList.innerHTML = selectAllHtml + html;

                                    // Add select all functionality
                                    const selectAllCheckbox = document.getElementById('selectAllStudents');
                                    const studentCheckboxes = studentsList.querySelectorAll(
                                        'input[name="peserta_didik_ids[]"]');

                                    if (selectAllCheckbox) {
                                        selectAllCheckbox.addEventListener('change', function() {
                                            studentCheckboxes.forEach(checkbox => {
                                                checkbox.checked = this.checked;
                                            });
                                        });

                                        // Update select all when individual checkboxes change
                                        studentCheckboxes.forEach(checkbox => {
                                            checkbox.addEventListener('change', function() {
                                                const checkedCount = Array.from(
                                                    studentCheckboxes).filter(cb => cb
                                                    .checked).length;
                                                selectAllCheckbox.checked = checkedCount ===
                                                    studentCheckboxes.length;
                                                selectAllCheckbox.indeterminate =
                                                    checkedCount > 0 && checkedCount <
                                                    studentCheckboxes.length;
                                            });
                                        });
                                    }

                                } else {
                                    studentsList.innerHTML = `
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="text-gray-500 text-sm mt-2">Tidak ada siswa dengan perhitungan TOPSIS</p>
                            <p class="text-gray-400 text-xs">untuk tahun ajaran ${tahunAjaran}</p>
                        </div>
                    `;
                                }
                            })
                            .catch(error => {
                                console.error('Error loading students:', error);
                                studentsList.innerHTML = `
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                        <p class="text-red-500 text-sm mt-2">Error loading data siswa</p>
                        <p class="text-red-400 text-xs">${error.message}</p>
                        <button onclick="this.parentElement.parentElement.previousElementSibling.dispatchEvent(new Event('change'))" 
                                class="mt-2 px-3 py-1 bg-red-100 text-red-700 rounded text-xs hover:bg-red-200">
                            Coba Lagi
                        </button>
                    </div>
                `;
                            });
                    });
                }

                // Rest of your existing JavaScript code...
            });
        </script>
    @endpush
@endsection
