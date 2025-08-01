@extends('layouts.admin')

@section('title', 'Buat Laporan')
@section('page-title', 'Buat Laporan Baru')
@section('page-description', 'Generate laporan sistem pendukung keputusan')

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
                <p class="text-gray-600 mb-4">Generate ringkasan statistik dan analisis untuk semua siswa dalam periode
                    tertentu.</p>
                <button onclick="openModal('summary')"
                    class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
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
            <div class="bg-white rounded-xl max-w-2xl w-full p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-navy">Buat Laporan Individual</h3>
                    <button onclick="closeModal('individual')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.laporan.generate.individual') }}">
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
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Pilih Peserta Didik <span class="text-red-500">*</span>
                            </label>
                            <div class="max-h-48 overflow-y-auto border border-gray-300 rounded-lg p-3">
                                <div class="space-y-2" id="studentsList">
                                    <p class="text-gray-500 text-sm">Pilih tahun ajaran terlebih dahulu</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeModal('individual')"
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-200">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
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
            <div class="bg-white rounded-xl max-w-lg w-full p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-navy">Buat Laporan Perbandingan</h3>
                    <button onclick="closeModal('comparison')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.laporan.generate.comparison') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Pilih Tahun Ajaran untuk Dibandingkan <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-2 max-h-32 overflow-y-auto border border-gray-300 rounded-lg p-3">
                                @foreach ($tahunAjaran as $tahun)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="tahun_ajaran[]" value="{{ $tahun }}"
                                            class="rounded border-gray-300 text-navy focus:ring-navy">
                                        <span class="ml-2 text-sm text-gray-700">{{ $tahun }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Pilih minimal 2 tahun ajaran</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kriteria Perbandingan</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="comparison_criteria[]" value="total_siswa" checked
                                        class="rounded border-gray-300 text-navy focus:ring-navy">
                                    <span class="ml-2 text-sm text-gray-700">Total siswa</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="comparison_criteria[]" value="rekomendasi_jurusan"
                                        checked class="rounded border-gray-300 text-navy focus:ring-navy">
                                    <span class="ml-2 text-sm text-gray-700">Distribusi rekomendasi jurusan</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="comparison_criteria[]" value="nilai_preferensi"
                                        class="rounded border-gray-300 text-navy focus:ring-navy">
                                    <span class="ml-2 text-sm text-gray-700">Nilai preferensi rata-rata</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeModal('comparison')"
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-200">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-200">
                            Generate Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function openModal(type) {
                document.getElementById(type + 'Modal').classList.remove('hidden');
            }

            function closeModal(type) {
                document.getElementById(type + 'Modal').classList.add('hidden');
            }

            // Load students when academic year is selected
            document.getElementById('individual_tahun_ajaran').addEventListener('change', function() {
                const tahunAjaran = this.value;
                const studentsList = document.getElementById('studentsList');

                if (!tahunAjaran) {
                    studentsList.innerHTML = '<p class="text-gray-500 text-sm">Pilih tahun ajaran terlebih dahulu</p>';
                    return;
                }

                // Here you would typically make an AJAX call to get students
                // For now, we'll show a loading message
                studentsList.innerHTML = '<p class="text-gray-500 text-sm">Loading siswa...</p>';

                // Simulate API call
                setTimeout(() => {
                    studentsList.innerHTML = `
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="peserta_didik_ids[]" value="1" class="rounded border-gray-300 text-navy focus:ring-navy">
                                <span class="ml-2 text-sm text-gray-700">Ahmad Fauzi - 1234567890</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="peserta_didik_ids[]" value="2" class="rounded border-gray-300 text-navy focus:ring-navy">
                                <span class="ml-2 text-sm text-gray-700">Siti Nurhaliza - 0987654321</span>
                            </label>
                            <p class="text-xs text-gray-500 mt-2">Data siswa untuk tahun ajaran ${tahunAjaran}</p>
                        </div>
                    `;
                }, 500);
            });

            // Close modal when clicking outside
            document.querySelectorAll('.fixed.inset-0').forEach(modal => {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        this.classList.add('hidden');
                    }
                });
            });
        </script>
    @endpush
@endsection
