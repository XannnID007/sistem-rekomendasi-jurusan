@extends('layouts.admin')

@section('title', 'Tambah Peserta Didik')
@section('page-title', 'Tambah Peserta Didik')
@section('page-description', 'Tambahkan data peserta didik baru')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-navy">Formulir Data Peserta Didik</h3>
                <p class="text-sm text-gray-600 mt-1">Lengkapi semua data yang diperlukan</p>
            </div>

            <form method="POST" action="{{ route('admin.peserta-didik.store') }}" class="p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- NISN -->
                    <div>
                        <label for="nisn" class="block text-sm font-medium text-gray-700 mb-2">
                            NISN <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nisn" name="nisn" value="{{ old('nisn') }}" maxlength="10"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('nisn') border-red-500 @enderror"
                            placeholder="Masukkan NISN (10 digit)" required>
                        @error('nisn')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('nama_lengkap') border-red-500 @enderror"
                            placeholder="Masukkan nama lengkap" required>
                        @error('nama_lengkap')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_kelamin" id="jenis_kelamin"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('jenis_kelamin') border-red-500 @enderror"
                            required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('tanggal_lahir') border-red-500 @enderror"
                            required>
                        @error('tanggal_lahir')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tahun Ajaran -->
                    <div>
                        <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700 mb-2">
                            Tahun Ajaran <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="tahun_ajaran" name="tahun_ajaran"
                            value="{{ old('tahun_ajaran', '2024/2025') }}" pattern="[0-9]{4}/[0-9]{4}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('tahun_ajaran') border-red-500 @enderror"
                            placeholder="2024/2025" required>
                        @error('tahun_ajaran')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('email') border-red-500 @enderror"
                            placeholder="email@contoh.com">
                        <p class="mt-1 text-xs text-gray-500">Kosongkan untuk menggunakan email default
                            (NISN@student.smkpenida2.sch.id)</p>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Alamat -->
                <div class="mt-6">
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat
                    </label>
                    <textarea id="alamat" name="alamat" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('alamat') border-red-500 @enderror"
                        placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <!-- No Telepon -->
                    <div>
                        <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-2">
                            No. Telepon Siswa
                        </label>
                        <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('no_telepon') border-red-500 @enderror"
                            placeholder="08xxxxxxxxxx">
                        @error('no_telepon')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password" name="password"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('password') border-red-500 @enderror"
                            placeholder="Minimal 6 karakter" required>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Orang Tua -->
                    <div>
                        <label for="nama_orang_tua" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Orang Tua
                        </label>
                        <input type="text" id="nama_orang_tua" name="nama_orang_tua"
                            value="{{ old('nama_orang_tua') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('nama_orang_tua') border-red-500 @enderror"
                            placeholder="Nama ayah/ibu">
                        @error('nama_orang_tua')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No Telepon Orang Tua -->
                    <div>
                        <label for="no_telepon_orang_tua" class="block text-sm font-medium text-gray-700 mb-2">
                            No. Telepon Orang Tua
                        </label>
                        <input type="text" id="no_telepon_orang_tua" name="no_telepon_orang_tua"
                            value="{{ old('no_telepon_orang_tua') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('no_telepon_orang_tua') border-red-500 @enderror"
                            placeholder="08xxxxxxxxxx">
                        @error('no_telepon_orang_tua')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.peserta-didik.index') }}"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-navy text-white rounded-lg hover:bg-navy-dark transition duration-200">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Auto-generate email based on NISN
            document.getElementById('nisn').addEventListener('input', function() {
                const nisn = this.value;
                const emailField = document.getElementById('email');

                if (nisn.length === 10 && !emailField.value) {
                    emailField.value = nisn + '@student.smkpenida2.sch.id';
                }
            });

            // Validate NISN format
            document.getElementById('nisn').addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
            });

            // Format phone numbers
            document.querySelectorAll('input[type="text"][placeholder*="08"]').forEach(function(input) {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            });
        </script>
    @endpush

@endsection
