@extends('layouts.admin')

@section('title', 'Detail Submission')
@section('page-title', 'Detail Submission')

@section('content')
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-8 border border-gray-100">
            <h3 class="text-xl font-bold text-navy mb-6">Data Peserta Didik</h3>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="text-sm text-gray-600">NISN</label>
                    <p class="font-semibold">{{ $pesertaDidik->nisn }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Nama Lengkap</label>
                    <p class="font-semibold">{{ $pesertaDidik->nama_lengkap }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <p class="font-semibold">{{ $pesertaDidik->email_submission }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">No. Telepon</label>
                    <p class="font-semibold">{{ $pesertaDidik->no_telepon_submission }}</p>
                </div>
            </div>
        </div>

        @if ($pesertaDidik->perhitunganTerbaru)
            <div class="bg-white rounded-xl shadow-sm p-8 border border-gray-100">
                <h3 class="text-xl font-bold text-navy mb-6">Hasil Rekomendasi</h3>
                <div
                    class="bg-{{ $pesertaDidik->perhitunganTerbaru->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-50 rounded-xl p-6">
                    <p class="text-sm text-gray-600 mb-2">Rekomendasi Sistem:</p>
                    <h4
                        class="text-2xl font-bold text-{{ $pesertaDidik->perhitunganTerbaru->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-900">
                        {{ $pesertaDidik->perhitunganTerbaru->jurusan_rekomendasi }}
                    </h4>
                    <p class="text-sm text-gray-600 mt-2">
                        Nilai Preferensi:
                        <strong>{{ number_format($pesertaDidik->perhitunganTerbaru->nilai_preferensi, 4) }}</strong>
                    </p>
                </div>
            </div>
        @endif

        @if ($penilaian)
            <div class="bg-white rounded-xl shadow-sm p-8 border border-gray-100">
                <h3 class="text-xl font-bold text-navy mb-6">Status Konfirmasi</h3>

                @if ($penilaian->status_submission === 'pending')
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                        <div class="flex items-center space-x-3 mb-4">
                            <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="font-semibold text-yellow-800">PENDING - Menunggu Konfirmasi Siswa</span>
                        </div>
                        <p class="text-sm text-yellow-700">Siswa belum memberikan konfirmasi terhadap rekomendasi.</p>
                    </div>
                @elseif($penilaian->status_submission === 'approved')
                    <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                        <div class="flex items-center space-x-3 mb-4">
                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="font-semibold text-green-800">APPROVED - Siswa Menyetujui</span>
                        </div>
                        <p class="text-sm text-green-700">Siswa telah menyetujui rekomendasi sistem pada
                            {{ \Carbon\Carbon::parse($penilaian->tanggal_submission)->format('d/m/Y H:i') }}</p>
                    </div>
                @else
                    <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                        <div class="flex items-center space-x-3 mb-4">
                            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="font-semibold text-red-800">REJECTED - Siswa Memilih Jurusan Lain</span>
                        </div>
                        <div class="mt-4 bg-white rounded-lg p-4">
                            <div class="mb-3">
                                <label class="text-sm text-gray-600">Jurusan yang Dipilih:</label>
                                <p class="font-bold text-navy text-lg">
                                    {{ $penilaian->jurusan_dipilih }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-600">Alasan Penolakan:</label>
                                <p class="text-gray-800">{{ $penilaian->alasan_penolakan }}</p>
                            </div>
                        </div>

                        <div class="mt-6 bg-white rounded-lg p-6 border-2 border-orange-200">
                            <h4 class="font-bold text-gray-900 mb-4">🔧 Override Jurusan (Admin)</h4>
                            <form action="{{ route('admin.submission.override', $penilaian->penilaian_id) }}"
                                method="POST">
                                @csrf
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Ubah Jurusan
                                            Menjadi:</label>
                                        <select name="jurusan_baru" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                            <option value="TKJ">TKJ - Teknik Komputer dan Jaringan</option>
                                            <option value="TKR">TKR - Teknik Kendaraan Ringan</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Admin
                                            (Opsional):</label>
                                        <textarea name="catatan_admin" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                                            placeholder="Alasan perubahan..."></textarea>
                                    </div>
                                    <button type="submit"
                                        class="bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700 font-semibold">
                                        Ubah & Approve
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <div class="flex justify-between">
            <a href="{{ route('admin.submission.index') }}" class="text-gray-600 hover:text-gray-900">
                ← Kembali
            </a>

            <div class="flex space-x-3">
                @if ($penilaian && $penilaian->status_submission === 'pending')
                    <form action="{{ route('admin.submission.approve', $penilaian->penilaian_id) }}" method="POST"
                        onsubmit="return confirm('Approve submission ini?')">
                        @csrf
                        <button type="submit"
                            class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 font-semibold">
                            Approve Manual
                        </button>
                    </form>
                @endif

                <form action="{{ route('admin.submission.destroy', $penilaian->penilaian_id) }}" method="POST"
                    onsubmit="return confirm('PERINGATAN: Menghapus submission ini akan menghapus data user, peserta didik, penilaian, dan perhitungan yang terkait. Lanjutkan?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 font-semibold">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
