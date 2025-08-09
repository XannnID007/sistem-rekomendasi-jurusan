<div class="section">
    <h3>Laporan Perbandingan Antar Tahun Ajaran</h3>

    @php
        $comparison = $data['comparison'] ?? [];
        $tahunAjaran = $data['tahun_ajaran'] ?? [];
    @endphp

    @if (!empty($comparison) && count($comparison) > 0)
        <!-- Overview Table -->
        <table>
            <thead>
                <tr>
                    <th>Tahun Ajaran</th>
                    <th class="text-center">Total Siswa</th>
                    <th class="text-center">TKJ</th>
                    <th class="text-center">TKR</th>
                    <th class="text-center">% TKJ</th>
                    <th class="text-center">% TKR</th>
                    <th class="text-center">Rata-rata</th>
                    <th class="text-center">Tertinggi</th>
                    <th class="text-center">Terendah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($comparison as $tahun => $stats)
                    @php
                        $totalSiswa = $stats['total_siswa'] ?? 0;
                        $tkjCount = $stats['tkj_count'] ?? 0;
                        $tkrCount = $stats['tkr_count'] ?? 0;
                        $rataPreferensi = $stats['rata_preferensi'] ?? 0;
                        $tertinggi = $stats['tertinggi'] ?? 0;
                        $terendah = $stats['terendah'] ?? 0;
                    @endphp
                    <tr>
                        <td style="font-weight: bold;">{{ $tahun }}</td>
                        <td class="text-center">{{ $totalSiswa }}</td>
                        <td class="text-center">{{ $tkjCount }}</td>
                        <td class="text-center">{{ $tkrCount }}</td>
                        <td class="text-center">
                            @if ($totalSiswa > 0)
                                {{ number_format(($tkjCount / $totalSiswa) * 100, 1) }}%
                            @else
                                0%
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($totalSiswa > 0)
                                {{ number_format(($tkrCount / $totalSiswa) * 100, 1) }}%
                            @else
                                0%
                            @endif
                        </td>
                        <td class="text-center">{{ number_format($rataPreferensi, 4) }}</td>
                        <td class="text-center">{{ number_format($tertinggi, 4) }}</td>
                        <td class="text-center">{{ number_format($terendah, 4) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Detailed Analysis -->
        <div class="section">
            <h4>Analisis Perbandingan</h4>

            @php
                $totalStudents = array_sum(array_column($comparison, 'total_siswa'));
                $totalTKJ = array_sum(array_column($comparison, 'tkj_count'));
                $totalTKR = array_sum(array_column($comparison, 'tkr_count'));
                $avgPreference =
                    count($comparison) > 0
                        ? array_sum(array_column($comparison, 'rata_preferensi')) / count($comparison)
                        : 0;
            @endphp

            <div class="info-box">
                <h5>Ringkasan Keseluruhan</h5>
                <div class="info-grid">
                    <div class="info-row">
                        <span class="info-label">Total Siswa (Semua Tahun):</span>
                        <span class="info-value">{{ $totalStudents }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Total Rekomendasi TKJ:</span>
                        <span class="info-value">
                            {{ $totalTKJ }}
                            @if ($totalStudents > 0)
                                ({{ number_format(($totalTKJ / $totalStudents) * 100, 1) }}%)
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Total Rekomendasi TKR:</span>
                        <span class="info-value">
                            {{ $totalTKR }}
                            @if ($totalStudents > 0)
                                ({{ number_format(($totalTKR / $totalStudents) * 100, 1) }}%)
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Rata-rata Nilai Preferensi:</span>
                        <span class="info-value">{{ number_format($avgPreference, 4) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trend Analysis -->
        <div class="section">
            <h4>Analisis Tren</h4>

            @php
                $years = array_keys($comparison);
                sort($years);
            @endphp

            @if (count($years) >= 2)
                @php
                    $firstYear = $years[0];
                    $lastYear = end($years);

                    $firstYearData = $comparison[$firstYear] ?? [];
                    $lastYearData = $comparison[$lastYear] ?? [];

                    $studentGrowth = ($lastYearData['total_siswa'] ?? 0) - ($firstYearData['total_siswa'] ?? 0);
                    $tkjGrowth = ($lastYearData['tkj_count'] ?? 0) - ($firstYearData['tkj_count'] ?? 0);
                    $tkrGrowth = ($lastYearData['tkr_count'] ?? 0) - ($firstYearData['tkr_count'] ?? 0);
                    $preferenceGrowth =
                        ($lastYearData['rata_preferensi'] ?? 0) - ($firstYearData['rata_preferensi'] ?? 0);
                @endphp

                <div class="info-box">
                    <h5>Perbandingan {{ $firstYear }} vs {{ $lastYear }}</h5>
                    <div class="info-grid">
                        <div class="info-row">
                            <span class="info-label">Perubahan Jumlah Siswa:</span>
                            <span class="info-value">
                                {{ $studentGrowth > 0 ? '+' : '' }}{{ $studentGrowth }} siswa
                                @if (($firstYearData['total_siswa'] ?? 0) > 0)
                                    ({{ number_format(($studentGrowth / $firstYearData['total_siswa']) * 100, 1) }}%)
                                @endif
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Perubahan Rekomendasi TKJ:</span>
                            <span class="info-value">
                                {{ $tkjGrowth > 0 ? '+' : '' }}{{ $tkjGrowth }} siswa
                                @if (($firstYearData['tkj_count'] ?? 0) > 0)
                                    ({{ number_format(($tkjGrowth / $firstYearData['tkj_count']) * 100, 1) }}%)
                                @endif
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Perubahan Rekomendasi TKR:</span>
                            <span class="info-value">
                                {{ $tkrGrowth > 0 ? '+' : '' }}{{ $tkrGrowth }} siswa
                                @if (($firstYearData['tkr_count'] ?? 0) > 0)
                                    ({{ number_format(($tkrGrowth / $firstYearData['tkr_count']) * 100, 1) }}%)
                                @endif
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Perubahan Rata-rata Preferensi:</span>
                            <span class="info-value">
                                {{ $preferenceGrowth > 0 ? '+' : '' }}{{ number_format($preferenceGrowth, 4) }}
                                @if (($firstYearData['rata_preferensi'] ?? 0) > 0)
                                    ({{ number_format(($preferenceGrowth / $firstYearData['rata_preferensi']) * 100, 2) }}%)
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Year by Year Analysis -->
            @foreach ($comparison as $tahun => $stats)
                @php
                    $totalSiswa = $stats['total_siswa'] ?? 0;
                    $tkjCount = $stats['tkj_count'] ?? 0;
                    $tkrCount = $stats['tkr_count'] ?? 0;
                    $rataPreferensi = $stats['rata_preferensi'] ?? 0;
                    $tertinggi = $stats['tertinggi'] ?? 0;
                    $terendah = $stats['terendah'] ?? 0;
                @endphp

                <div class="section">
                    <h5>Detail Tahun Ajaran {{ $tahun }}</h5>
                    <div class="info-box">
                        <div class="stats-row">
                            <div class="stats-item">
                                <span class="stats-number">{{ $totalSiswa }}</span>
                                <div class="stats-label">Total Siswa</div>
                            </div>
                            <div class="stats-item">
                                <span class="stats-number">{{ $tkjCount }}</span>
                                <div class="stats-label">Rekomendasi TKJ</div>
                            </div>
                            <div class="stats-item">
                                <span class="stats-number">{{ $tkrCount }}</span>
                                <div class="stats-label">Rekomendasi TKR</div>
                            </div>
                            <div class="stats-item">
                                <span class="stats-number">{{ number_format($rataPreferensi, 3) }}</span>
                                <div class="stats-label">Rata-rata Preferensi</div>
                            </div>
                        </div>

                        <div style="margin-top: 15px;">
                            <strong>Karakteristik:</strong>
                            <ul style="margin: 5px 0; padding-left: 20px;">
                                @if ($totalSiswa > 0)
                                    <li>
                                        @if ($tkjCount > $tkrCount)
                                            Mayoritas siswa ({{ number_format(($tkjCount / $totalSiswa) * 100, 1) }}%)
                                            direkomendasikan untuk TKJ
                                        @elseif($tkrCount > $tkjCount)
                                            Mayoritas siswa ({{ number_format(($tkrCount / $totalSiswa) * 100, 1) }}%)
                                            direkomendasikan untuk TKR
                                        @else
                                            Distribusi rekomendasi seimbang antara TKJ dan TKR
                                        @endif
                                    </li>
                                    <li>
                                        @if ($rataPreferensi > 0.35)
                                            Rata-rata nilai preferensi tinggi ({{ number_format($rataPreferensi, 4) }})
                                        @elseif($rataPreferensi > 0.25)
                                            Rata-rata nilai preferensi sedang ({{ number_format($rataPreferensi, 4) }})
                                        @else
                                            Rata-rata nilai preferensi rendah ({{ number_format($rataPreferensi, 4) }})
                                        @endif
                                    </li>
                                    <li>Rentang nilai: {{ number_format($terendah, 4) }} -
                                        {{ number_format($tertinggi, 4) }}</li>
                                @else
                                    <li>Tidak ada data untuk tahun ajaran ini</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Recommendations -->
        <div class="section">
            <h4>Rekomendasi Berdasarkan Analisis</h4>
            <div class="info-box">
                <p><strong>Berdasarkan analisis perbandingan, berikut adalah rekomendasi:</strong></p>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    @if ($totalTKJ > $totalTKR)
                        <li>Persiapkan kapasitas yang lebih besar untuk jurusan TKJ karena mayoritas siswa menunjukkan
                            kesesuaian dengan bidang teknologi komputer</li>
                        <li>Tingkatkan fasilitas laboratorium komputer dan jaringan</li>
                        <li>Rekrut lebih banyak guru dengan kompetensi di bidang TIK</li>
                    @else
                        <li>Persiapkan kapasitas yang lebih besar untuk jurusan TKR karena mayoritas siswa menunjukkan
                            kesesuaian dengan bidang otomotif</li>
                        <li>Tingkatkan fasilitas bengkel otomotif dan peralatan praktikum</li>
                        <li>Rekrut lebih banyak guru dengan kompetensi di bidang otomotif</li>
                    @endif

                    @if ($avgPreference < 0.3)
                        <li>Rata-rata nilai preferensi masih rendah, perlu peningkatan kualitas input siswa atau
                            penyesuaian kurikulum</li>
                    @else
                        <li>Rata-rata nilai preferensi sudah baik, pertahankan kualitas input dan proses pembelajaran
                        </li>
                    @endif

                    <li>Lakukan evaluasi berkala terhadap kriteria penilaian TOPSIS untuk memastikan relevansi</li>
                    <li>Berikan bimbingan karir yang lebih intensif untuk membantu siswa memahami potensi diri</li>
                </ul>
            </div>
        </div>
    @else
        <div class="no-data">
            <p>Tidak ada data untuk perbandingan.</p>
            <p>Silakan pastikan data perhitungan TOPSIS tersedia untuk tahun ajaran yang dipilih.</p>
            @if (!empty($tahunAjaran))
                <p>Tahun ajaran yang diminta: {{ implode(', ', $tahunAjaran) }}</p>
            @endif
        </div>
    @endif
</div>
