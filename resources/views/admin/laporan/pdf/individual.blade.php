<div class="section">
    <h3>Laporan Individual</h3>

    <!-- Statistics Overview -->
    <div class="stats-grid">
        <div class="stats-row">
            <div class="stats-item">
                <span class="stats-number">{{ $data['total_siswa'] }}</span>
                <div class="stats-label">Total Siswa</div>
            </div>
            <div class="stats-item">
                <span class="stats-number">{{ number_format($data['rata_preferensi'], 4) }}</span>
                <div class="stats-label">Rata-rata Preferensi</div>
            </div>
            <div class="stats-item">
                <span class="stats-number">{{ $data['tkj_count'] }}</span>
                <div class="stats-label">Rekomendasi TKJ</div>
            </div>
            <div class="stats-item">
                <span class="stats-number">{{ $data['tkr_count'] }}</span>
                <div class="stats-label">Rekomendasi TKR</div>
            </div>
        </div>
    </div>

    <!-- Students Detail Table -->
    @if ($data['perhitungan']->count() > 0)
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
                @foreach ($data['perhitungan'] as $index => $perhitungan)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $perhitungan->pesertaDidik->nama_lengkap }}</td>
                        <td class="text-center">{{ $perhitungan->pesertaDidik->nisn }}</td>
                        <td class="text-center">{{ $perhitungan->pesertaDidik->jenis_kelamin_lengkap }}</td>
                        <td class="text-center">{{ number_format($perhitungan->nilai_preferensi, 4) }}</td>
                        <td class="text-center">
                            <span
                                class="badge {{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'badge-tkj' : 'badge-tkr' }}">
                                {{ $perhitungan->rekomendasi_lengkap }}
                            </span>
                        </td>
                        <td class="text-center">{{ $perhitungan->tanggal_perhitungan->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Detail Analysis for Each Student -->
        <div class="page-break"></div>
        <div class="section">
            <h3>Detail Analisis Per Siswa</h3>

            @foreach ($data['perhitungan'] as $index => $perhitungan)
                @if ($index > 0)
                    <div class="page-break"></div>
                @endif

                <div class="section">
                    <h4>{{ $index + 1 }}. {{ $perhitungan->pesertaDidik->nama_lengkap }}
                        ({{ $perhitungan->pesertaDidik->nisn }})</h4>

                    <div class="info-box">
                        <div class="info-grid">
                            <div class="info-row">
                                <div class="info-label">Rekomendasi Jurusan:</div>
                                <div class="info-value">
                                    <span
                                        class="badge {{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'badge-tkj' : 'badge-tkr' }}">
                                        {{ $perhitungan->rekomendasi_lengkap }}
                                    </span>
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Nilai Preferensi:</div>
                                <div class="info-value">{{ number_format($perhitungan->nilai_preferensi, 6) }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Jarak ke Solusi Positif:</div>
                                <div class="info-value">{{ number_format($perhitungan->jarak_positif, 6) }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Jarak ke Solusi Negatif:</div>
                                <div class="info-value">{{ number_format($perhitungan->jarak_negatif, 6) }}</div>
                            </div>
                        </div>
                    </div>

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
                                <td class="text-center">{{ $perhitungan->penilaian->nilai_ipa }}</td>
                                <td class="text-center">{{ number_format($perhitungan->normalized_n1, 4) }}</td>
                                <td class="text-center">{{ number_format($perhitungan->weighted_n1, 4) }}</td>
                            </tr>
                            <tr>
                                <td>IPS</td>
                                <td class="text-center">{{ $perhitungan->penilaian->nilai_ips }}</td>
                                <td class="text-center">{{ number_format($perhitungan->normalized_n2, 4) }}</td>
                                <td class="text-center">{{ number_format($perhitungan->weighted_n2, 4) }}</td>
                            </tr>
                            <tr>
                                <td>Matematika</td>
                                <td class="text-center">{{ $perhitungan->penilaian->nilai_matematika }}</td>
                                <td class="text-center">{{ number_format($perhitungan->normalized_n3, 4) }}</td>
                                <td class="text-center">{{ number_format($perhitungan->weighted_n3, 4) }}</td>
                            </tr>
                            <tr>
                                <td>Bahasa Indonesia</td>
                                <td class="text-center">{{ $perhitungan->penilaian->nilai_bahasa_indonesia }}</td>
                                <td class="text-center">{{ number_format($perhitungan->normalized_n4, 4) }}</td>
                                <td class="text-center">{{ number_format($perhitungan->weighted_n4, 4) }}</td>
                            </tr>
                            <tr>
                                <td>Bahasa Inggris</td>
                                <td class="text-center">{{ $perhitungan->penilaian->nilai_bahasa_inggris }}</td>
                                <td class="text-center">{{ number_format($perhitungan->normalized_n5, 4) }}</td>
                                <td class="text-center">{{ number_format($perhitungan->weighted_n5, 4) }}</td>
                            </tr>
                            <tr>
                                <td>Produktif</td>
                                <td class="text-center">{{ $perhitungan->penilaian->nilai_produktif }}</td>
                                <td class="text-center">{{ number_format($perhitungan->normalized_n6, 4) }}</td>
                                <td class="text-center">{{ number_format($perhitungan->weighted_n6, 4) }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Minat & Keahlian -->
                    <h5>Minat dan Keahlian</h5>
                    <div class="info-grid">
                        <div class="info-row">
                            <div class="info-label">Minat A:</div>
                            <div class="info-value">{{ $perhitungan->penilaian->minat_a }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Minat B:</div>
                            <div class="info-value">{{ $perhitungan->penilaian->minat_b }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Minat C:</div>
                            <div class="info-value">{{ $perhitungan->penilaian->minat_c }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Minat D:</div>
                            <div class="info-value">{{ $perhitungan->penilaian->minat_d }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Keahlian:</div>
                            <div class="info-value">{{ $perhitungan->penilaian->keahlian }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Penghasilan Orang Tua:</div>
                            <div class="info-value">{{ $perhitungan->penilaian->penghasilan_ortu }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="no-data">
            <p>Tidak ada data perhitungan untuk laporan individual ini.</p>
        </div>
    @endif
</div>
