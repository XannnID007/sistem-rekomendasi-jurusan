{{-- resources/views/admin/laporan/pdf/individual.blade.php --}}
<div class="section">
    <h3>Laporan Individual</h3>

    @php
        $totalSiswa = $data['total_siswa'] ?? 0;
        $rataPreferensi = $data['rata_preferensi'] ?? 0;
        $tkjCount = $data['tkj_count'] ?? 0;
        $tkrCount = $data['tkr_count'] ?? 0;
        $perhitungan = $data['perhitungan'] ?? collect();
    @endphp

    <!-- Statistics Overview -->
    <div class="stats-grid">
        <div class="stats-row">
            <div class="stats-item">
                <span class="stats-number">{{ $totalSiswa }}</span>
                <div class="stats-label">Total Siswa</div>
            </div>
            <div class="stats-item">
                <span class="stats-number">{{ number_format($rataPreferensi, 4) }}</span>
                <div class="stats-label">Rata-rata Preferensi</div>
            </div>
            <div class="stats-item">
                <span class="stats-number">{{ $tkjCount }}</span>
                <div class="stats-label">Rekomendasi TKJ</div>
            </div>
            <div class="stats-item">
                <span class="stats-number">{{ $tkrCount }}</span>
                <div class="stats-label">Rekomendasi TKR</div>
            </div>
        </div>
    </div>

    <!-- Students Detail Table -->
    @if ($perhitungan && $perhitungan->count() > 0)
        <table>
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Nama Lengkap</th>
                    <th class="text-center">NISN</th>
                    <th class="text-center">Jenis Kelamin</th>
                    <th class="text-center">Nilai Preferensi</th>
                    <th class="text-center">Rekomendasi</th>
                    <th class="text-center">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($perhitungan as $index => $item)
                    @php
                        $pesertaDidik = $item->pesertaDidik ?? null;
                        $nilaiPreferensi = $item->nilai_preferensi ?? 0;
                        $jurusanRekomendasi = $item->jurusan_rekomendasi ?? 'N/A';
                        $tanggalPerhitungan = null;

                        // Handle date safely
                        if (isset($item->tanggal_perhitungan) && $item->tanggal_perhitungan) {
                            try {
                                if (
                                    is_object($item->tanggal_perhitungan) &&
                                    method_exists($item->tanggal_perhitungan, 'format')
                                ) {
                                    $tanggalPerhitungan = $item->tanggal_perhitungan->format('d/m/Y');
                                } elseif (is_string($item->tanggal_perhitungan)) {
                                    $tanggalPerhitungan = \Carbon\Carbon::parse($item->tanggal_perhitungan)->format(
                                        'd/m/Y',
                                    );
                                }
                            } catch (\Exception $e) {
                                $tanggalPerhitungan = 'N/A';
                            }
                        }

                        if (!$tanggalPerhitungan && isset($item->created_at)) {
                            try {
                                if (is_object($item->created_at) && method_exists($item->created_at, 'format')) {
                                    $tanggalPerhitungan = $item->created_at->format('d/m/Y');
                                } elseif (is_string($item->created_at)) {
                                    $tanggalPerhitungan = \Carbon\Carbon::parse($item->created_at)->format('d/m/Y');
                                }
                            } catch (\Exception $e) {
                                $tanggalPerhitungan = 'N/A';
                            }
                        }

                        $tanggalPerhitungan = $tanggalPerhitungan ?: 'N/A';
                    @endphp

                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $pesertaDidik->nama_lengkap ?? 'N/A' }}</td>
                        <td class="text-center">{{ $pesertaDidik->nisn ?? 'N/A' }}</td>
                        <td class="text-center">
                            @if ($pesertaDidik && $pesertaDidik->jenis_kelamin)
                                {{ $pesertaDidik->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="text-center">{{ number_format($nilaiPreferensi, 4) }}</td>
                        <td class="text-center">
                            <span class="badge {{ $jurusanRekomendasi === 'TKJ' ? 'badge-tkj' : 'badge-tkr' }}">
                                @if ($jurusanRekomendasi === 'TKJ')
                                    TKJ (Teknik Komputer dan Jaringan)
                                @elseif($jurusanRekomendasi === 'TKR')
                                    TKR (Teknik Kendaraan Ringan)
                                @else
                                    {{ $jurusanRekomendasi }}
                                @endif
                            </span>
                        </td>
                        <td class="text-center">{{ $tanggalPerhitungan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Detail Analysis for Each Student -->
        <div class="page-break"></div>
        <div class="section">
            <h3>Detail Analisis Per Siswa</h3>

            @foreach ($perhitungan as $index => $item)
                @if ($index > 0)
                    <div class="page-break"></div>
                @endif

                @php
                    $pesertaDidik = $item->pesertaDidik ?? null;
                    $penilaian = $item->penilaian ?? null;
                    $nilaiPreferensi = $item->nilai_preferensi ?? 0;
                    $jurusanRekomendasi = $item->jurusan_rekomendasi ?? 'N/A';
                    $jarakPositif = $item->jarak_positif ?? 0;
                    $jarakNegatif = $item->jarak_negatif ?? 0;
                @endphp

                <div class="section">
                    <h4>{{ $index + 1 }}. {{ $pesertaDidik->nama_lengkap ?? 'N/A' }}
                        ({{ $pesertaDidik->nisn ?? 'N/A' }})
                    </h4>

                    <div class="info-box">
                        <div class="info-grid">
                            <div class="info-row">
                                <div class="info-label">Rekomendasi Jurusan:</div>
                                <div class="info-value">
                                    <span
                                        class="badge {{ $jurusanRekomendasi === 'TKJ' ? 'badge-tkj' : 'badge-tkr' }}">
                                        @if ($jurusanRekomendasi === 'TKJ')
                                            TKJ (Teknik Komputer dan Jaringan)
                                        @elseif($jurusanRekomendasi === 'TKR')
                                            TKR (Teknik Kendaraan Ringan)
                                        @else
                                            {{ $jurusanRekomendasi }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Nilai Preferensi:</div>
                                <div class="info-value">{{ number_format($nilaiPreferensi, 6) }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Jarak ke Solusi Positif:</div>
                                <div class="info-value">{{ number_format($jarakPositif, 6) }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Jarak ke Solusi Negatif:</div>
                                <div class="info-value">{{ number_format($jarakNegatif, 6) }}</div>
                            </div>
                        </div>
                    </div>

                    @if ($penilaian)
                        <!-- Academic Scores -->
                        <h5>Nilai Akademik</h5>
                        <table>
                            <thead>
                                <tr>
                                    <th>Mata Pelajaran</th>
                                    <th class="text-center">Nilai</th>
                                    <th class="text-center">Normalized</th>
                                    <th class="text-center">Weighted</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>IPA</td>
                                    <td class="text-center">{{ $penilaian->nilai_ipa ?? 'N/A' }}</td>
                                    <td class="text-center">{{ number_format($item->normalized_n1 ?? 0, 4) }}</td>
                                    <td class="text-center">{{ number_format($item->weighted_n1 ?? 0, 4) }}</td>
                                </tr>
                                <tr>
                                    <td>IPS</td>
                                    <td class="text-center">{{ $penilaian->nilai_ips ?? 'N/A' }}</td>
                                    <td class="text-center">{{ number_format($item->normalized_n2 ?? 0, 4) }}</td>
                                    <td class="text-center">{{ number_format($item->weighted_n2 ?? 0, 4) }}</td>
                                </tr>
                                <tr>
                                    <td>Matematika</td>
                                    <td class="text-center">{{ $penilaian->nilai_matematika ?? 'N/A' }}</td>
                                    <td class="text-center">{{ number_format($item->normalized_n3 ?? 0, 4) }}</td>
                                    <td class="text-center">{{ number_format($item->weighted_n3 ?? 0, 4) }}</td>
                                </tr>
                                <tr>
                                    <td>Bahasa Indonesia</td>
                                    <td class="text-center">{{ $penilaian->nilai_bahasa_indonesia ?? 'N/A' }}</td>
                                    <td class="text-center">{{ number_format($item->normalized_n4 ?? 0, 4) }}</td>
                                    <td class="text-center">{{ number_format($item->weighted_n4 ?? 0, 4) }}</td>
                                </tr>
                                <tr>
                                    <td>Bahasa Inggris</td>
                                    <td class="text-center">{{ $penilaian->nilai_bahasa_inggris ?? 'N/A' }}</td>
                                    <td class="text-center">{{ number_format($item->normalized_n5 ?? 0, 4) }}</td>
                                    <td class="text-center">{{ number_format($item->weighted_n5 ?? 0, 4) }}</td>
                                </tr>
                                <tr>
                                    <td>PKN</td>
                                    <td class="text-center">{{ $penilaian->nilai_pkn ?? 'N/A' }}</td>
                                    <td class="text-center">{{ number_format($item->normalized_n6 ?? 0, 4) }}</td>
                                    <td class="text-center">{{ number_format($item->weighted_n6 ?? 0, 4) }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Minat & Keahlian -->
                        <h5>Minat dan Keahlian</h5>
                        <div class="info-grid">
                            <div class="info-row">
                                <div class="info-label">Minat A:</div>
                                <div class="info-value">{{ $penilaian->minat_a ?? 'N/A' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Minat B:</div>
                                <div class="info-value">{{ $penilaian->minat_b ?? 'N/A' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Minat C:</div>
                                <div class="info-value">{{ $penilaian->minat_c ?? 'N/A' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Minat D:</div>
                                <div class="info-value">{{ $penilaian->minat_d ?? 'N/A' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Keahlian:</div>
                                <div class="info-value">{{ $penilaian->keahlian ?? 'N/A' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Biaya Gelombang:</div>
                                <div class="info-value">{{ $penilaian->biaya_gelombang ?? 'N/A' }}</div>
                            </div>
                        </div>
                    @else
                        <div class="info-box">
                            <p>Data penilaian tidak tersedia untuk siswa ini.</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="no-data">
            <p>Tidak ada data perhitungan untuk laporan individual ini.</p>
            <p>Pastikan data perhitungan TOPSIS sudah tersedia untuk siswa yang dipilih.</p>
        </div>
    @endif
</div>
