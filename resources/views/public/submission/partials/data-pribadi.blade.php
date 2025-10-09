{{-- resources/views/public/submission/partials/data-pribadi.blade.php --}}

<div>
    <label for="nisn" class="block text-sm font-medium text-gray-700">NISN</label>
    <input type="text" id="nisn" name="nisn" maxlength="10" value="{{ old('nisn') }}" required
        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-navy focus:border-navy">
</div>
<div>
    <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
    <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-navy focus:border-navy">
</div>
<div>
    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
    <select id="jenis_kelamin" name="jenis_kelamin" required
        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-navy focus:border-navy">
        <option value="">Pilih...</option>
        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
    </select>
</div>
<div>
    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-navy focus:border-navy">
</div>
<div>
    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
    <input type="email" id="email" name="email" value="{{ old('email') }}" required
        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-navy focus:border-navy">
</div>
<div>
    <label for="no_telepon" class="block text-sm font-medium text-gray-700">No. Telepon</label>
    <input type="tel" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" required
        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-navy focus:border-navy">
</div>
<div class="md:col-span-2">
    <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
    <textarea id="alamat" name="alamat" rows="3" required
        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-navy focus:border-navy">{{ old('alamat') }}</textarea>
</div>
<div>
    <label for="nama_orang_tua" class="block text-sm font-medium text-gray-700">Nama Orang Tua</label>
    <input type="text" id="nama_orang_tua" name="nama_orang_tua" value="{{ old('nama_orang_tua') }}" required
        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-navy focus:border-navy">
</div>
<div>
    <label for="no_telepon_orang_tua" class="block text-sm font-medium text-gray-700">No. Telepon Orang Tua</label>
    <input type="tel" id="no_telepon_orang_tua" name="no_telepon_orang_tua"
        value="{{ old('no_telepon_orang_tua') }}" required
        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-navy focus:border-navy">
</div>
<div class="md:col-span-2">
    <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700">Tahun Ajaran Pendaftaran</label>
    <input type="text" id="tahun_ajaran" name="tahun_ajaran" value="{{ old('tahun_ajaran', '2024/2025') }}" required
        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-navy focus:border-navy bg-gray-50">
</div>
