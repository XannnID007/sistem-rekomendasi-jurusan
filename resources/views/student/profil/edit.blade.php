@extends('layouts.student')

@section('title', 'Edit Profil')
@section('page-title', 'Edit Profil')
@section('page-description', 'Perbarui informasi profil Anda')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-navy to-navy-dark">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gold rounded-full flex items-center justify-center">
                        <span class="text-navy font-bold text-lg">{{ substr($user->full_name, 0, 1) }}</span>
                    </div>
                    <div class="text-white">
                        <h3 class="text-lg font-semibold">Edit Profil</h3>
                        <p class="text-blue-100 text-sm">{{ $pesertaDidik->nama_lengkap }}</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('student.profil.update') }}" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-8">
                    <!-- Personal Information Section -->
                    <div>
                        <h4 class="text-lg font-semibold text-navy mb-4">Informasi Personal</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <div>
                                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="full_name" name="full_name"
                                    value="{{ old('full_name', $user->full_name) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('full_name') border-red-500 @enderror"
                                    required>
                                @error('full_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('email') border-red-500 @enderror"
                                    required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-2">
                                    No. Telepon
                                </label>
                                <input type="text" id="no_telepon" name="no_telepon"
                                    value="{{ old('no_telepon', $pesertaDidik->no_telepon) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('no_telepon') border-red-500 @enderror"
                                    placeholder="08xxxxxxxxxx">
                                @error('no_telepon')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Read-only fields for reference -->
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-2">NISN</label>
                                <input type="text" value="{{ $pesertaDidik->nisn }}"
                                    class="w-full px-3 py-2 bg-gray-100 border border-gray-200 rounded-lg text-gray-600"
                                    readonly>
                                <p class="mt-1 text-xs text-gray-500">NISN tidak dapat diubah</p>
                            </div>
                        </div>
                    </div>

                    <!-- Address Section -->
                    <div>
                        <h4 class="text-lg font-semibold text-navy mb-4">Alamat</h4>
                        <div>
                            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat Lengkap
                            </label>
                            <textarea id="alamat" name="alamat" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('alamat') border-red-500 @enderror"
                                placeholder="Masukkan alamat lengkap...">{{ old('alamat', $pesertaDidik->alamat) }}</textarea>
                            @error('alamat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Family Information Section -->
                    <div>
                        <h4 class="text-lg font-semibold text-navy mb-4">Informasi Keluarga</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Parent Name -->
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

                            <!-- Parent Phone -->
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
                    </div>

                    <!-- Read-Only Academic Information -->
                    <div>
                        <h4 class="text-lg font-semibold text-navy mb-4">Informasi Akademik</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-2">Jenis Kelamin</label>
                                <input type="text" value="{{ $pesertaDidik->jenis_kelamin_lengkap }}"
                                    class="w-full px-3 py-2 bg-gray-100 border border-gray-200 rounded-lg text-gray-600"
                                    readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-2">Tanggal Lahir</label>
                                <input type="text" value="{{ $pesertaDidik->tanggal_lahir->format('d F Y') }}"
                                    class="w-full px-3 py-2 bg-gray-100 border border-gray-200 rounded-lg text-gray-600"
                                    readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-2">Tahun Ajaran</label>
                                <input type="text" value="{{ $pesertaDidik->tahun_ajaran }}"
                                    class="w-full px-3 py-2 bg-gray-100 border border-gray-200 rounded-lg text-gray-600"
                                    readonly>
                            </div>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">
                            Informasi akademik tidak dapat diubah. Hubungi admin jika perlu perubahan.
                        </p>
                    </div>
                </div>

                <!-- Information Alert -->
                <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <h4 class="font-medium text-blue-800 mb-1">Informasi Penting</h4>
                            <div class="text-sm text-blue-700 space-y-1">
                                <p>• Pastikan informasi yang Anda masukkan sudah benar dan terkini</p>
                                <p>• Email akan digunakan untuk komunikasi penting dari sekolah</p>
                                <p>• No. telepon yang valid membantu dalam situasi darurat</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('student.profil.index') }}"
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
            // Format phone numbers
            document.querySelectorAll('input[placeholder*="08"]').forEach(function(input) {
                input.addEventListener('input', function() {
                    // Remove non-numeric characters
                    this.value = this.value.replace(/[^0-9]/g, '');

                    // Limit length to reasonable phone number length
                    if (this.value.length > 15) {
                        this.value = this.value.slice(0, 15);
                    }
                });
            });

            // Auto-resize textarea
            document.getElementById('alamat').addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            });
        </script>
    @endpush

@endsection
