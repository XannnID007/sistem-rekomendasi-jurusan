<div class="section">
    @php
        $filterType = $data['filter_type'] ?? 'all';
        $totalSiswa = $data['total_siswa'] ?? 0;
        $filterTitle = [
            'TKJ' => 'Siswa dengan Rekomendasi TKJ (Teknik Komputer dan Jaringan)',
            'TKR' => 'Siswa dengan Rekomendasi TKR (Teknik Kendaraan Ringan)',
            'all' => 'Semua Siswa (TKJ dan TKR)',
        ];
    @endphp

    <h3>{{ $filterTitle[$filterType] ?? 'Laporan Filter Rekomendasi' }}</h3>

    @if ($totalSiswa > 0)
        <!-- Filter Info -->
        <div class="info-box">
            <h4>Informasi Filter</h4>
            <div class="info-grid">
                <div class="info-row">
                    <span class="info-label">Filter Diterapkan:</span>
                    <span class="info-value">
                        @if ($filterType === 'TKJ')
                            <span class="badge badge-tkj">TKJ (Teknik Komputer dan Jaringan)</span>
                        @elseif($filterType === 'TKR')
                            <span class="badge badge-tkr">TKR (Teknik Kendaraan Ringan)</span>
                        @else
                            <span class="badge" style="background-color: #f3f4f6; color: #374151;">Semua
                                Rekomendasi</span>
                        @endif
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Total Siswa Ditemukan:</span>
                    <span class="info-value">{{ $totalSiswa }} siswa</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tahun Ajaran:</span>
                    <span class="info-value">{{ $laporan->tahun_ajaran }}</span>
                </div>
            </div>
        </div>

        <!-- Statistics Overview -->
        <div class="stats-row mb-4">
            <div class="stats-item">
                <span class="stats-number">{{ $totalSiswa }}</span>
                <div class="stats-label">Total Siswa</div>
            </div>
            <div class="stats-item">
                <span class="stats-number">{{ number_format($data['rata_preferensi'], 4) }}</span>
                <div class="stats-label">Rata-rata Preferensi</div>
            </div>
            <div class="stats-item">
                <span class="stats-number">{{ number_format($data['tertinggi'], 4) }}</span>
                <div class="stats-label">Tertinggi</div>
            </div>
            <div class="stats-item">
                <span class="stats-number">{{ number_format($data['terendah'], 4) }}</span>
                <div class="stats-label">Terendah</div>
            </div>
        </div>

        <!-- Gender Distribution -->
        <div class="section">
            <h4>Distribusi Berdasarkan Jenis Kelamin</h4>
            <table>
                <thead>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-center">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Laki-laki</td>
                        <td class="text-center">{{ $data['distribusi_gender']['laki'] }}</td>
                        <td class="text-center">
                            {{ number_format(($data['distribusi_gender']['laki'] / $totalSiswa) * 100, 1) }}%
                        </td>
                    </tr>
                    <tr>
                        <td>Perempuan</td>
                        <td class="text-center">{{ $data['distribusi_gender']['perempuan'] }}</td>
                        <td class="text-center">
                            {{ number_format(($data['distribusi_gender']['perempuan'] / $totalSiswa) * 100, 1) }}%
                        </td>
                    </tr>
                    <tr style="background-color: #f8f9fa; font-weight: bold;">
                        <td>Total</td>
                        <td class="text-center">{{ $totalSiswa }}</td>
                        <td class="text-center">100%</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Performance Statistics -->
        @if (isset($data['statistics']) && !empty($data['statistics']))
            <div class="section">
                <h4>Distribusi Berdasarkan Tingkat Nilai Preferensi</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Kategori Nilai</th>
                            <th class="text-center">Range</th>
                            <th class="text-center">Jumlah Siswa</th>
                            <th class="text-center">Persentase</th>
                            <th class="text-center">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Tinggi</td>
                            <td class="text-center">> 0.50</td>
                            <td class="text-center">{{ $data['statistics']['nilai_tinggi'] ?? 0 }}</td>
                            <td class="text-center">
                                {{ number_format($data['statistics']['persentase_tinggi'] ?? 0, 1) }}%</td>
                            <td class="text-center">Sangat Cocok</td>
                        </tr>
                        <tr>
                            <td>Sedang</td>
                            <td class="text-center">0.30 - 0.50</td>
                            <td class="text-center">{{ $data['statistics']['nilai_sedang'] ?? 0 }}</td>
                            <td class="text-center">
                                {{ number_format($data['statistics']['persentase_sedang'] ?? 0, 1) }}%</td>
                            <td class="text-center">Cukup Cocok</td>
                        </tr>
                        <tr>
                            <td>Rendah</td>
                            <td class="text-center">
                                < 0.30</td>
                            <td class="text-center">{{ $data['statistics']['nilai_rendah'] ?? 0 }}</td>
                            <td class="text-center">
                                {{ number_format($data['statistics']['persentase_rendah'] ?? 0, 1) }}%</td>
                            <td class="text-center">Kurang Cocok</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Analysis Section -->
        <div class="section">
            <h4>Analisis</h4>
            <div class="info-box">
                <p style="margin-bottom: 10px;"><strong>Analisis Berdasarkan Filter:</strong></p>
                <ul style="margin: 0; padding-left: 20px;">
                    @if ($filterType === 'TKJ')
                        <li>Total {{ $totalSiswa }} siswa yang direkomendasikan untuk jurusan TKJ (Teknik Komputer
                            dan Jaringan)</li>
                        <li>Rata-rata nilai preferensi: {{ number_format($data['rata_preferensi'], 4) }} (di atas
                            threshold 0.30)</li>
                        <li>Siswa-siswa ini menunjukkan kesesuaian yang baik dengan bidang teknologi informasi dan
                            komputer</li>
                        <li>Perlu dipersiapkan fasilitas laboratorium komputer dan jaringan yang memadai</li>
                    @elseif($filterType === 'TKR')
                        <li>Total {{ $totalSiswa }} siswa yang direkomendasikan untuk jurusan TKR (Teknik Kendaraan
                            Ringan)</li>
                        <li>Rata-rata nilai preferensi: {{ number_format($data['rata_preferensi'], 4) }} (di bawah atau
                            sama dengan threshold 0.30)</li>
                        <li>Siswa-siswa ini menunjukkan kesesuaian yang baik dengan bidang otomotif dan mekanik</li>
                        <li>Perlu dipersiapkan fasilitas bengkel otomotif dan peralatan praktikum yang lengkap</li>
                    @else
                        <li>Total {{ $totalSiswa }} siswa dari semua rekomendasi (TKJ dan TKR)</li>
                        <li>Menampilkan gambaran lengkap distribusi rekomendasi jurusan</li>
                    @endif

                    @if ($data['distribusi_gender']['laki'] > $data['distribusi_gender']['perempuan'])
                        <li>Mayoritas siswa berjenis kelamin laki-laki
                            ({{ number_format(($data['distribusi_gender']['laki'] / $totalSiswa) * 100, 1) }}%)</li>
                    @elseif($data['distribusi_gender']['perempuan'] > $data['distribusi_gender']['laki'])
                        <li>Mayoritas siswa berjenis kelamin perempuan
                            ({{ number_format(($data['distribusi_gender']['perempuan'] / $totalSiswa) * 100, 1) }}%)
                        </li>
                    @else
                        <li>Distribusi gender cukup seimbang</li>
                    @endif

                    <li>Rentang nilai preferensi: {{ number_format($data['terendah'], 4) }} -
                        {{ number_format($data['tertinggi'], 4) }}</li>
                </ul>
            </div>
        </div>

        <!-- Complete Students Data -->
        <div class="page-break"></div>
        <div class="section">
            <h4>Data Lengkap Siswa {{ $filterTitle[$filterType] ?? 'Filter' }}</h4>
            <table>
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nama Lengkap</th>
                        <th class="text-center">NISN</th>
                        <th class="text-center">L/P</th>
                        <th class="text-center">Nilai Preferensi</th>
                        <th class="text-center">Rekomendasi</th>
                        <th class="text-center">Kategori</th>
                        <th class="text-center">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['data_lengkap'] as $index => $perhitungan)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $perhitungan->pesertaDidik->nama_lengkap }}</td>
                            <td class="text-center">{{ $perhitungan->pesertaDidik->nisn }}</td>
                            <td class="text-center">{{ $perhitungan->pesertaDidik->jenis_kelamin }}</td>
                            <td class="text-center">{{ number_format($perhitungan->nilai_preferensi, 4) }}</td>
                            <td class="text-center">
                                <span
                                    class="badge {{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'badge-tkj' : 'badge-tkr' }}">
                                    {{ $perhitungan->jurusan_rekomendasi }}
                                </span>
                            </td>
                            <td class="text-center">
                                @php
                                    $nilai = $perhitungan->nilai_preferensi;
                                    if ($nilai > 0.5) {
                                        echo 'Tinggi';
                                    } elseif ($nilai >= 0.3) {
                                        echo 'Sedang';
                                    } else {
                                        echo 'Rendah';
                                    }
                                @endphp
                            </td>
                            <td class="text-center">
                                @php
                                    $tanggal = null;
                                    if (isset($perhitungan->tanggal_perhitungan) && $perhitungan->tanggal_perhitungan) {
                                        if (
                                            is_object($perhitungan->tanggal_perhitungan) &&
                                            method_exists($perhitungan->tanggal_perhitungan, 'format')
                                        ) {
                                            $tanggal = $perhitungan->tanggal_perhitungan->format('d/m/Y');
                                        } elseif (is_string($perhitungan->tanggal_perhitungan)) {
                                            $tanggal = \Carbon\Carbon::parse($perhitungan->tanggal_perhitungan)->format(
                                                'd/m/Y',
                                            );
                                        }
                                    }
                                    if (!$tanggal && isset($perhitungan->created_at)) {
                                        if (
                                            is_object($perhitungan->created_at) &&
                                            method_exists($perhitungan->created_at, 'format')
                                        ) {
                                            $tanggal = $perhitungan->created_at->format('d/m/Y');
                                        } elseif (is_string($perhitungan->created_at)) {
                                            $tanggal = \Carbon\Carbon::parse($perhitungan->created_at)->format('d/m/Y');
                                        }
                                    }
                                @endphp
                                {{ $tanggal ?: 'N/A' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Recommendations -->
        <div class="section">
            <h4>Rekomendasi Berdasarkan Analisis</h4>
            <div class="info-box">
                <p><strong>Berdasarkan analisis filter rekomendasi, berikut adalah rekomendasi:</strong></p>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    @if ($filterType === 'TKJ')
                        <li>Persiapkan kapasitas kelas TKJ untuk {{ $totalSiswa }} siswa</li>
                        <li>Tingkatkan fasilitas laboratorium komputer dan jaringan</li>
                        <li>Sediakan perangkat lunak pembelajaran yang up-to-date</li>
                        <li>Rekrut guru dengan kompetensi teknologi informasi dan jaringan</li>
                        <li>Kembangkan kerjasama dengan industri IT untuk program magang</li>
                        @if (isset($data['statistics']) && $data['statistics']['nilai_tinggi'] > $data['statistics']['nilai_sedang'])
                            <li>Mayoritas siswa memiliki potensi tinggi, pertimbangkan program akselerasi</li>
                        @endif
                    @elseif($filterType === 'TKR')
                        <li>Persiapkan kapasitas bengkel TKR untuk {{ $totalSiswa }} siswa</li>
                        <li>Lengkapi peralatan bengkel otomotif yang modern</li>
                        <li>Sediakan kendaraan untuk praktikum yang bervariasi</li>
                        <li>Rekrut guru dengan kompetensi bidang otomotif</li>
                        <li>Kembangkan kerjasama dengan bengkel dan dealer otomotif</li>
                        @if (isset($data['statistics']) && $data['statistics']['nilai_rendah'] > $data['statistics']['nilai_tinggi'])
                            <li>Beberapa siswa memiliki nilai preferensi rendah, perlukan bimbingan tambahan</li>
                        @endif
                    @else
                        <li>Seimbangkan kapasitas antara TKJ dan TKR berdasarkan distribusi aktual</li>
                        <li>Siapkan fasilitas yang memadai untuk kedua jurusan</li>
                        <li>Berikan bimbingan karir yang tepat untuk setiap siswa</li>
                    @endif

                    <li>Lakukan evaluasi berkala terhadap akurasi sistem rekomendasi</li>
                    <li>Berikan sosialisasi kepada siswa dan orang tua tentang prospek masing-masing jurusan</li>

                    @if ($data['distribusi_gender']['perempuan'] > 0 && $filterType === 'TKR')
                        <li>Siapkan fasilitas khusus untuk siswa perempuan di bengkel TKR</li>
                    @endif

                    @if ($data['distribusi_gender']['laki'] > 0 && $filterType === 'TKJ')
                        <li>Pastikan laboratorium TKJ dapat mengakomodasi semua siswa dengan baik</li>
                    @endif
                </ul>
            </div>
        </div>
    @else
        <div class="no-data">
            <p>Tidak ada data siswa untuk filter rekomendasi yang dipilih.</p>
            <p>Filter: {{ $filterTitle[$filterType] ?? 'Unknown' }}</p>
            <p>Silakan pastikan:</p>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Data perhitungan TOPSIS sudah tersedia untuk tahun ajaran {{ $laporan->tahun_ajaran }}</li>
                <li>Ada siswa yang memiliki rekomendasi {{ $filterType === 'all' ? 'TKJ atau TKR' : $filterType }}</li>
                <li>Proses perhitungan TOPSIS telah dijalankan dengan benar</li>
            </ul>
        </div>
    @endif
</div>
