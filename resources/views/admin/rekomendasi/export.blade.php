@extends('layouts.admin')

@section('title', 'Export Rekomendasi')
@section('page-title', 'Export Data Rekomendasi')
@section('page-description', 'Export hasil rekomendasi dalam berbagai format')

@section('content')
    <div class="space-y-6">
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.rekomendasi.index') }}"
                    class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-lg font-semibold text-navy">Export Data Rekomendasi</h2>
                    <p class="text-sm text-gray-600">Pilih format dan kustomisasi export sesuai kebutuhan</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.rekomendasi.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 00-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>
        </div>

        <!-- Export Options -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Excel Export -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a4 4 0 01-4-4V5a4 4 0 014-4h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a4 4 0 01-4 4z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-center text-gray-900 mb-2">Excel (.xlsx)</h3>
                <p class="text-sm text-gray-600 text-center mb-4">
                    Format Excel dengan formula dan formatting. Cocok untuk analisis data lebih lanjut.
                </p>
                <div class="space-y-3">
                    <form method="GET" action="{{ route('admin.rekomendasi.export') }}">
                        <input type="hidden" name="format" value="excel">
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Tahun Ajaran</label>
                                <select name="tahun_ajaran"
                                    class="w-full text-xs px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-navy">
                                    <option value="">Semua Tahun</option>
                                    <option value="2024/2025">2024/2025</option>
                                    <option value="2023/2024">2023/2024</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Format Delimiter</label>
                                <select name="delimiter"
                                    class="w-full text-xs px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-navy">
                                    <option value=",">Comma (,)</option>
                                    <option value=";">Semicolon (;)</option>
                                    <option value="|">Pipe (|)</option>
                                </select>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="include_header" value="1" id="csv_header" checked
                                    class="h-3 w-3 text-navy">
                                <label for="csv_header" class="ml-1 text-xs text-gray-700">Include Header Row</label>
                            </div>
                        </div>
                        <button type="submit"
                            class="w-full mt-4 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200 text-sm font-medium">
                            Download CSV
                        </button>
                    </form>
                </div>
            </div>

            <!-- PDF Export -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-center text-gray-900 mb-2">PDF (.pdf)</h3>
                <p class="text-sm text-gray-600 text-center mb-4">
                    Format PDF dengan layout profesional. Cocok untuk presentasi dan dokumentasi.
                </p>
                <div class="space-y-3">
                    <form method="GET" action="{{ route('admin.rekomendasi.export') }}">
                        <input type="hidden" name="format" value="pdf">
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Tahun Ajaran</label>
                                <select name="tahun_ajaran"
                                    class="w-full text-xs px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-navy">
                                    <option value="">Semua Tahun</option>
                                    <option value="2024/2025">2024/2025</option>
                                    <option value="2023/2024">2023/2024</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Layout</label>
                                <select name="layout"
                                    class="w-full text-xs px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-navy">
                                    <option value="portrait">Portrait</option>
                                    <option value="landscape">Landscape</option>
                                </select>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="include_charts" value="1" id="pdf_charts"
                                    class="h-3 w-3 text-navy">
                                <label for="pdf_charts" class="ml-1 text-xs text-gray-700">Include Charts</label>
                            </div>
                        </div>
                        <button type="submit"
                            class="w-full mt-4 bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition duration-200 text-sm font-medium">
                            Download PDF
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Custom Export -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-navy mb-4">Custom Export</h3>
            <p class="text-sm text-gray-600 mb-6">Buat export kustom dengan pilihan field dan filter yang lebih detail</p>

            <form method="GET" action="{{ route('admin.rekomendasi.export') }}" id="customExportForm">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Format Selection -->
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-3">Format Output</h4>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="format" value="excel" checked class="h-4 w-4 text-navy">
                                <span class="ml-2 text-sm text-gray-700">Excel (.xlsx)</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="format" value="csv" class="h-4 w-4 text-navy">
                                <span class="ml-2 text-sm text-gray-700">CSV (.csv)</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="format" value="pdf" class="h-4 w-4 text-navy">
                                <span class="ml-2 text-sm text-gray-700">PDF (.pdf)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-3">Filter Data</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran</label>
                                <select name="tahun_ajaran"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent">
                                    <option value="">Semua Tahun</option>
                                    <option value="2024/2025">2024/2025</option>
                                    <option value="2023/2024">2023/2024</option>
                                    <option value="2022/2023">2022/2023</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Rekomendasi Jurusan</label>
                                <select name="jurusan_rekomendasi"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent">
                                    <option value="">Semua Jurusan</option>
                                    <option value="TKJ">TKJ (Teknik Komputer dan Jaringan)</option>
                                    <option value="TKR">TKR (Teknik Kendaraan Ringan)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                                <select name="jenis_kelamin"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent">
                                    <option value="">Semua</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Range Nilai Preferensi</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="number" name="min_preferensi" placeholder="Min" step="0.0001"
                                        min="0" max="1"
                                        class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent">
                                    <input type="number" name="max_preferensi" placeholder="Max" step="0.0001"
                                        min="0" max="1"
                                        class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Field Selection -->
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-3">Field yang Disertakan</h4>
                        <div class="space-y-2 max-h-48 overflow-y-auto">
                            <label class="flex items-center">
                                <input type="checkbox" name="fields[]" value="nama_lengkap" checked
                                    class="h-4 w-4 text-navy">
                                <span class="ml-2 text-sm text-gray-700">Nama Lengkap</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="fields[]" value="nisn" checked class="h-4 w-4 text-navy">
                                <span class="ml-2 text-sm text-gray-700">NISN</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="fields[]" value="jenis_kelamin" class="h-4 w-4 text-navy">
                                <span class="ml-2 text-sm text-gray-700">Jenis Kelamin</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="fields[]" value="tahun_ajaran" checked
                                    class="h-4 w-4 text-navy">
                                <span class="ml-2 text-sm text-gray-700">Tahun Ajaran</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="fields[]" value="nilai_preferensi" checked
                                    class="h-4 w-4 text-navy">
                                <span class="ml-2 text-sm text-gray-700">Nilai Preferensi</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="fields[]" value="jurusan_rekomendasi" checked
                                    class="h-4 w-4 text-navy">
                                <span class="ml-2 text-sm text-gray-700">Rekomendasi Jurusan</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="fields[]" value="ranking" class="h-4 w-4 text-navy">
                                <span class="ml-2 text-sm text-gray-700">Ranking</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="fields[]" value="jarak_positif" class="h-4 w-4 text-navy">
                                <span class="ml-2 text-sm text-gray-700">Jarak Solusi Positif</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="fields[]" value="jarak_negatif" class="h-4 w-4 text-navy">
                                <span class="ml-2 text-sm text-gray-700">Jarak Solusi Negatif</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="fields[]" value="tanggal_perhitungan"
                                    class="h-4 w-4 text-navy">
                                <span class="ml-2 text-sm text-gray-700">Tanggal Perhitungan</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="fields[]" value="nilai_akademik" class="h-4 w-4 text-navy">
                                <span class="ml-2 text-sm text-gray-700">Nilai Akademik</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="fields[]" value="minat" class="h-4 w-4 text-navy">
                                <span class="ml-2 text-sm text-gray-700">Data Minat</span>
                            </label>
                        </div>

                        <div class="mt-3 pt-3 border-t border-gray-200">
                            <button type="button" onclick="selectAllFields()"
                                class="text-xs text-navy hover:text-navy-dark">
                                Pilih Semua
                            </button>
                            <span class="text-gray-300 mx-2">|</span>
                            <button type="button" onclick="deselectAllFields()"
                                class="text-xs text-gray-500 hover:text-gray-700">
                                Batal Pilih
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Export Options -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3">Opsi Export</h4>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="sort_by_ranking" value="1" checked
                                        class="h-4 w-4 text-navy">
                                    <span class="ml-2 text-sm text-gray-700">Urutkan berdasarkan ranking</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="include_summary" value="1"
                                        class="h-4 w-4 text-navy">
                                    <span class="ml-2 text-sm text-gray-700">Sertakan ringkasan statistik</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="include_metadata" value="1"
                                        class="h-4 w-4 text-navy">
                                    <span class="ml-2 text-sm text-gray-700">Sertakan metadata export</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3">Nama File</h4>
                            <input type="text" name="filename" placeholder="rekomendasi_jurusan"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent">
                            <p class="text-xs text-gray-500 mt-1">
                                Kosongkan untuk menggunakan nama otomatis. Ekstensi file akan ditambahkan otomatis.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex space-x-4">
                        <button type="submit"
                            class="flex-1 bg-navy text-white px-6 py-3 rounded-lg hover:bg-navy-dark transition duration-200 font-medium">
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Export Data
                        </button>
                        <button type="button" onclick="previewData()"
                            class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-200 font-medium">
                            Preview Data
                        </button>
                        <button type="reset"
                            class="px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200 font-medium">
                            Reset
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Recent Exports -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-navy mb-4">Export Terbaru</h3>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama File
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Format
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ukuran
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Sample data - in real implementation, this would come from database -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                rekomendasi_2024_complete.xlsx
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Excel
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                2.5 MB
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ now()->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="#" class="text-navy hover:text-navy-dark mr-3" title="Download">
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </a>
                                <a href="#" class="text-red-600 hover:text-red-900" title="Hapus">
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                rekomendasi_tkj_only.csv
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    CSV
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                156 KB
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ now()->subHours(2)->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="#" class="text-navy hover:text-navy-dark mr-3" title="Download">
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </a>
                                <a href="#" class="text-red-600 hover:text-red-900" title="Hapus">
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Information Card -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
            <div class="flex items-start space-x-3">
                <svg class="w-6 h-6 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h4 class="font-medium text-blue-800 mb-2">Tips Export Data</h4>
                    <div class="text-sm text-blue-700 space-y-2">
                        <p>• <strong>Excel:</strong> Terbaik untuk analisis data dengan formula dan formatting</p>
                        <p>• <strong>CSV:</strong> Cocok untuk import ke sistem lain atau database</p>
                        <p>• <strong>PDF:</strong> Ideal untuk presentasi dan dokumentasi formal</p>
                        <p>• File export akan disimpan sementara dan dapat diunduh dalam 24 jam</p>
                        <p>• Gunakan custom export untuk kontrol penuh atas data yang diekspor</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function selectAllFields() {
                const checkboxes = document.querySelectorAll('input[name="fields[]"]');
                checkboxes.forEach(checkbox => checkbox.checked = true);
            }

            function deselectAllFields() {
                const checkboxes = document.querySelectorAll('input[name="fields[]"]');
                checkboxes.forEach(checkbox => checkbox.checked = false);
            }

            function previewData() {
                // Get form data
                const formData = new FormData(document.getElementById('customExportForm'));

                // Create preview URL
                const params = new URLSearchParams();
                for (let [key, value] of formData.entries()) {
                    params.append(key, value);
                }
                params.append('preview', '1');

                // Open preview in new window
                const previewUrl = '{{ route('admin.rekomendasi.export') }}?' + params.toString();
                window.open(previewUrl, '_blank', 'width=1000,height=600');
            }

            // Form validation
            document.getElementById('customExportForm').addEventListener('submit', function(e) {
                const selectedFields = document.querySelectorAll('input[name="fields[]"]:checked');
                if (selectedFields.length === 0) {
                    e.preventDefault();
                    alert('Pilih minimal satu field untuk diekspor.');
                    return;
                }

                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML =
                    '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Memproses...';
                submitBtn.disabled = true;

                // Reset button after 5 seconds
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 5000);
            });
        </script>
    @endpush

@endsection
