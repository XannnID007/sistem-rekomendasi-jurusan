<div class="section">
    <h3>Laporan Ringkasan</h3>

    @if (isset($data['total_siswa']) && $data['total_siswa'] > 0)
        <!-- Overall Statistics -->
        <div class="stats-row mb-4">
            <div class="stats-item">
                <span class="stats-number">{{ $data['total_siswa'] }}</span>
                <div class="stats-label">Total Siswa</div>
            </div>
            <div class="stats-item">
                <span class="stats-number">{{ $data['tkj_count'] }}</span>
                <div class="stats-label">Rekomendasi TKJ</div>
            </div>
            <div class="stats-item">
                <span class="stats-number">{{ $data['tkr_count'] }}</span>
                <div class="stats-label">Rekomendasi TKR</div>
            </div>
            <div class="stats-item">
                <span class="stats-number">{{ number_format(($data['tkj_count'] / $data['total_siswa']) * 100, 1) }}%</span>
                <div class="stats-label">Persentase TKJ</div>
            </div>
        </div>

        <!-- Performance Statistics -->
        <div class="section">
            <h4>Statistik Nilai Preferensi</h4>
            <div class="info-box">
                <div class="info-grid">
                    <div class="info-row">
                        <span class="info-label">Rata-rata:</span>
                        <span class="info-value">{{ number_format($data['rata_preferensi'], 4) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nilai Tertinggi:</span>
                        <span class="info-value">{{ number_format($data['tertinggi'], 4) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nilai Terendah:</span>
                        <span class="info-value">{{ number_format($data['terendah'], 4) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Rentang:</span>
                        <span class="info-value">{{ number_format($data['tertinggi'] - $data['terendah'], 4) }}</span>
                    </div>
                </div>
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
                        <th class="text-center">TKJ</th>
                        <th class="text-center">TKR</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Laki-laki</td>
                        <td class="text-center">{{ $data['distribusi_gender']['laki'] }}</td>
                        <td class="text-center">
                            {{ number_format(($data['distribusi_gender']['laki'] / $data['total_siswa']) * 100, 1) }}%</td>
                        <td class="text-center">-</td>
                        <td class="text-center">-</td>
                    </tr>
                    <tr>
                        <td>Perempuan</td>
                        <td class="text-center">{{ $data['distribusi_gender']['perempuan'] }}</td>
                        <td class="text-center">
                            {{ number_format(($data['distribusi_gender']['perempuan'] / $data['total_siswa']) * 100, 1) }}%
                        </td>
                        <td class="text-center">-</td>
                        <td class="text-center">-</td>
                    </tr>
                    <tr style="background-color: #f8f9fa; font-weight: bold;">
                        <td>Total</td>
                        <td class="text-center">{{ $data['total_siswa'] }}</td>
                        <td class="text-center">100%</td>
                        <td class="text-center">{{ $data['tkj_count'] }}</td>
                        <td class="text-center">{{ $data['tkr_count'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Top Performers -->
        @if (isset($data['top_performers']) && $data['top_performers']->count() > 0)
            <div class="section">
                <h4>Top 10 Performer (Nilai Preferensi Tertinggi)</h4>
                <table>
                    <thead>
                        <tr>
                            <th class="text-center">Ranking</th>
                            <th>Nama Lengkap</th>
                            <th class="text-center">NISN</th>
                            <th class="text-center">L/P</th>
                            <th class="text-center">Nilai Preferensi</th>
                            <th class="text-center">Rekomendasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['top_performers'] as $index => $perhitungan)
                            <tr>
                                <td class="text-center" style="font-weight: bold;">{{ $index + 1 }}</td>
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Distribution Analysis -->
        <div class="section">
            <h4>Analisis Distribusi Rekomendasi</h4>
            <div class="info-box">
                <p style="margin-bottom: 10px;"><strong>Analisis:</strong></p>
                <ul style="margin: 0; padding-left: 20px;">
                    <li>Total {{ $data['tkj_count'] }} siswa
                        ({{ number_format(($data['tkj_count'] / $data['total_siswa']) * 100, 1) }}%) direkomendasikan untuk
                        jurusan TKJ (Teknik Komputer dan Jaringan)</li>
                    <li>Total {{ $data['tkr_count'] }} siswa
                        ({{ number_format(($data['tkr_count'] / $data['total_siswa']) * 100, 1) }}%) direkomendasikan untuk
                        jurusan TKR (Teknik Kendaraan Ringan)</li>
                    @if ($data['tkj_count'] > $data['tkr_count'])
                        <li>Mayoritas siswa lebih cocok untuk jurusan TKJ berdasarkan kriteria TOPSIS</li>
                    @elseif($data['tkr_count'] > $data['tkj_count'])
                        <li>Mayoritas siswa lebih cocok untuk jurusan TKR berdasarkan kriteria TOPSIS</li>
                    @else
                        <li>Distribusi rekomendasi cukup seimbang antara TKJ dan TKR</li>
                    @endif
                    <li>Rata-rata nilai preferensi adalah {{ number_format($data['rata_preferensi'], 4) }} dengan
                        threshold 0.30</li>
                </ul>
            </div>
        </div>

        <!-- All Students Data -->
        @if (isset($data['data_lengkap']) && $data['data_lengkap']->count() > 0)
            <div class="page-break"></div>
            <div class="section">
                <h4>Data Lengkap Semua Siswa</h4>
                <table>
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Lengkap</th>
                            <th class="text-center">NISN</th>
                            <th class="text-center">L/P</th>
                            <th class="text-center">Nilai Preferensi</th>
                            <th class="text-center">Rekomendasi</th>
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
                                        $tanggal = null;
                                        if (
                                            isset($perhitungan->tanggal_perhitungan) &&
                                            $perhitungan->tanggal_perhitungan
                                        ) {
                                            if (
                                                is_object($perhitungan->tanggal_perhitungan) &&
                                                method_exists($perhitungan->tanggal_perhitungan, 'format')
                                            ) {
                                                $tanggal = $perhitungan->tanggal_perhitungan->format('d/m/Y');
                                            } elseif (is_string($perhitungan->tanggal_perhitungan)) {
                                                $tanggal = \Carbon\Carbon::parse(
                                                    $perhitungan->tanggal_perhitungan,
                                                )->format('d/m/Y');
                                            }
                                        }
                                        if (!$tanggal && isset($perhitungan->created_at)) {
                                            if (
                                                is_object($perhitungan->created_at) &&
                                                method_exists($perhitungan->created_at, 'format')
                                            ) {
                                                $tanggal = $perhitungan->created_at->format('d/m/Y');
                                            } elseif (is_string($perhitungan->created_at)) {
                                                $tanggal = \Carbon\Carbon::parse($perhitungan->created_at)->format(
                                                    'd/m/Y',
                                                );
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
        @endif
    @else
        <div class="no-data">
            <p>Tidak ada data perhitungan untuk tahun ajaran ini.</p>
            <p>Silakan pastikan data perhitungan TOPSIS sudah tersedia.</p>
        </div>
    @endif
</div>
