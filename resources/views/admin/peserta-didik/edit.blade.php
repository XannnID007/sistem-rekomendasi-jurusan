@extends('layouts.admin')

@section('title', 'Edit Peserta Didik')
@section('page-title', 'Edit Peserta Didik')
@section('page-description', 'Edit data: ' . $pesertaDidik->nama_lengkap)

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-navy to-navy-dark">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gold rounded-full flex items-center justify-center">
                        <span class="text-navy font-bold">{{ substr($pesertaDidik->nama_lengkap, 0, 1) }}</span>
                    </div>
                    <div class="text-white">
                        <h3 class="text-lg font-semibold">Edit Data Peserta Didik</h3>
                        <p class="text-blue-100 text-sm">{{ $pesertaDidik->nama_lengkap }} - {{ $pesertaDidik->nisn }}</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.peserta-didik.update', $pesertaDidik) }}" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- NISN -->
                    <div>
                        <label for="nisn" class="block text-sm font-medium text-gray-700 mb-2">
                            NISN <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nisn" name="nisn" value="{{ old('nisn', $pesertaDidik->nisn) }}"
                            maxlength="10"
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
                        <input type="text" id="nama_lengkap" name="nama_lengkap"
                            value="{{ old('nama_lengkap', $pesertaDidik->nama_lengkap) }}"
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
                            <option value="L"
                                {{ old('jenis_kelamin', $pesertaDidik->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki
                            </option>
                            <option value="P"
                                {{ old('jenis_kelamin', $pesertaDidik->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan
                            </option>
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
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                            value="{{ old('tanggal_lahir', $pesertaDidik->tanggal_lahir ? \Carbon\Carbon::parse($pesertaDidik->tanggal_lahir)->format('Y-m-d') : '') }}"
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
                            value="{{ old('tahun_ajaran', $pesertaDidik->tahun_ajaran) }}" pattern="[0-9]{4}/[0-9]{4}"
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
                        <input type="email" id="email" name="email"
                            value="{{ old('email', $pesertaDidik->user->email ?? '') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('email') border-red-500 @enderror"
                            placeholder="email@contoh.com">
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
                        placeholder="Masukkan alamat lengkap">{{ old('alamat', $pesertaDidik->alamat) }}</textarea>
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
                        <input type="text" id="no_telepon" name="no_telepon"
                            value="{{ old('no_telepon', $pesertaDidik->no_telepon) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('no_telepon') border-red-500 @enderror"
                            placeholder="08xxxxxxxxxx">
                        @error('no_telepon')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password Baru
                        </label>
                        <input type="password" id="password" name="password"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('password') border-red-500 @enderror"
                            placeholder="Kosongkan jika tidak ingin mengubah">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah password</p>
                    </div>

                    <!-- Nama Orang Tua -->
                    <div>
                        <label for="nama_orang_tua" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Orang Tua
                        </label>
                        <input type="text" id="nama_orang_tua" name="nama_orang_tua"
                            value="{{ old('nama_orang_tua', $pesertaDidik->nama_orang_tua) }}"
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
                            value="{{ old('no_telepon_orang_tua', $pesertaDidik->no_telepon_orang_tua) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('no_telepon_orang_tua') border-red-500 @enderror"
                            placeholder="08xxxxxxxxxx">
                        @error('no_telepon_orang_tua')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status Akun -->
                <div class="mt-6">
                    <div class="flex items-center">
                        <input id="is_active" name="is_active" type="checkbox" value="1"
                            {{ old('is_active', $pesertaDidik->user->is_active ?? true) ? 'checked' : '' }}
                            class="h-4 w-4 text-navy focus:ring-navy border-gray-300 rounded">
                        <label for="is_active" class="ml-3 block text-sm font-medium text-gray-700">
                            Akun aktif
                        </label>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Centang untuk mengaktifkan akun siswa</p>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.peserta-didik.show', $pesertaDidik) }}"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-navy text-white rounded-lg hover:bg-navy-dark transition duration-200">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
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
