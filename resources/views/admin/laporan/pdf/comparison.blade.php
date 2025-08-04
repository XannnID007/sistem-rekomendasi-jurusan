<div class="section">
    <h3>Laporan Perbandingan Antar Tahun Ajaran</h3>

    @if (isset($data['comparison']) && count($data['comparison']) > 0)
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
                @foreach ($data['comparison'] as $tahun => $stats)
                    <tr>
                        <td style="font-weight: bold;">{{ $tahun }}</td>
                        <td class="text-center">{{ $stats['total_siswa'] }}</td>
                        <td class="text-center">{{ $stats['tkj_count'] }}</td>
                        <td class="text-center">{{ $stats['tkr_count'] }}</td>
                        <td class="text-center">
                            @if ($stats['total_siswa'] > 0)
                                {{ number_format(($stats['tkj_count'] / $stats['total_siswa']) * 100, 1) }}%
                            @else
                                0%
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($stats['total_siswa'] > 0)
                                {{ number_format(($stats['tkr_count'] / $stats['total_siswa']) * 100, 1) }}%
                            @else
                                0%
                            @endif
                        </td>
                        <td class="text-center">{{ number_format($stats['rata_preferensi'], 4) }}</td>
                        <td class="text-center">{{ number_format($stats['tertinggi'], 4) }}</td>
                        <td class="text-center">{{ number_format($stats['terendah'], 4) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Detailed Analysis -->
        <div class="section">
            <h4>Analisis Perbandingan</h4>

            @php
                $totalStudents = array_sum(array_column($data['comparison'], 'total_siswa'));
                $totalTKJ = array_sum(array_column($data['comparison'], 'tkj_count'));
                $totalTKR = array_sum(array_column($data['comparison'], 'tkr_count'));
                $avgPreference =
                    count($data['comparison']) > 0
                        ? array_sum(array_column($data['comparison'], 'rata_preferensi')) / count($data['comparison'])
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
                        <span class="info-value">{{ $totalTKJ }} @if ($totalStudents > 0)
                                ({{ number_format(($totalTKJ / $totalStudents) * 100, 1) }}%)
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Total Rekomendasi TKR:</span>
                        <span class="info-value">{{ $totalTKR }} @if ($totalStudents > 0)
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
                $years = array_keys($data['comparison']);
                sort($years);
            @endphp

            @if (count($years) >= 2)
                @php
                    $firstYear = $years[0];
                    $lastYear = end($years);

                    $studentGrowth =
                        $data['comparison'][$lastYear]['total_siswa'] - $data['comparison'][$firstYear]['total_siswa'];
                    $tkjGrowth =
                        $data['comparison'][$lastYear]['tkj_count'] - $data['comparison'][$firstYear]['tkj_count'];
                    $tkrGrowth =
                        $data['comparison'][$lastYear]['tkr_count'] - $data['comparison'][$firstYear]['tkr_count'];
                    $preferenceGrowth =
                        $data['comparison'][$lastYear]['rata_preferensi'] -
                        $data['comparison'][$firstYear]['rata_preferensi'];
                @endphp

                <div class="info-box">
                    <h5>Perbandingan {{ $firstYear }} vs {{ $lastYear }}</h5>
                    <div class="info-grid">
                        <div class="info-row">
                            <span class="info-label">Perubahan Jumlah Siswa:</span>
                            <span class="info-value">
                                {{ $studentGrowth > 0 ? '+' : '' }}{{ $studentGrowth }} siswa
                                @if ($data['comparison'][$firstYear]['total_siswa'] > 0)
                                    ({{ number_format(($studentGrowth / $data['comparison'][$firstYear]['total_siswa']) * 100, 1) }}%)
                                @endif
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Perubahan Rekomendasi TKJ:</span>
                            <span class="info-value">
                                {{ $tkjGrowth > 0 ? '+' : '' }}{{ $tkjGrowth }} siswa
                                @if ($data['comparison'][$firstYear]['tkj_count'] > 0)
                                    ({{ number_format(($tkjGrowth / $data['comparison'][$firstYear]['tkj_count']) * 100, 1) }}%)
                                @endif
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Perubahan Rekomendasi TKR:</span>
                            <span class="info-value">
                                {{ $tkrGrowth > 0 ? '+' : '' }}{{ $tkrGrowth }} siswa
                                @if ($data['comparison'][$firstYear]['tkr_count'] > 0)
                                    ({{ number_format(($tkrGrowth / $data['comparison'][$firstYear]['tkr_count']) * 100, 1) }}%)
                                @endif
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Perubahan Rata-rata Preferensi:</span>
                            <span class="info-value">
                                {{ $preferenceGrowth > 0 ? '+' : '' }}{{ number_format($preferenceGrowth, 4) }}
                                @if ($data['comparison'][$firstYear]['rata_preferensi'] > 0)
                                    ({{ number_format(($preferenceGrowth / $data['comparison'][$firstYear]['rata_preferensi']) * 100, 2) }}%)
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Year by Year Analysis -->
            @foreach ($data['comparison'] as $tahun => $stats)
                <div class="section">
                    <h5>Detail Tahun Ajaran {{ $tahun }}</h5>
                    <div class="info-box">
                        <div class="stats-row">
                            <div class="stats-item">
                                <span class="stats-number">{{ $stats['total_siswa'] }}</span>
                                <div class="stats-label">Total Siswa</div>
                            </div>
                            <div class="stats-item">
                                <span class="stats-number">{{ $stats['tkj_count'] }}</span>
                                <div class="stats-label">Rekomendasi TKJ</div>
                            </div>
                            <div class="stats-item">
                                <span class="stats-number">{{ $stats['tkr_count'] }}</span>
                                <div class="stats-label">Rekomendasi TKR</div>
                            </div>
                            <div class="stats-item">
                                <span class="stats-number">{{ number_format($stats['rata_preferensi'], 3) }}</span>
                                <div class="stats-label">Rata-rata Preferensi</div>
                            </div>
                        </div>

                        <div style="margin-top: 15px;">
                            <strong>Karakteristik:</strong>
                            <ul style="margin: 5px 0; padding-left: 20px;">
                                @if ($stats['total_siswa'] > 0)
                                    <li>
                                        @if ($stats['tkj_count'] > $stats['tkr_count'])
                                            Mayoritas siswa
                                            ({{ number_format(($stats['tkj_count'] / $stats['total_siswa']) * 100, 1) }}%)
                                            direkomendasikan untuk TKJ
                                        @elseif($stats['tkr_count'] > $stats['tkj_count'])
                                            Mayoritas siswa
                                            ({{ number_format(($stats['tkr_count'] / $stats['total_siswa']) * 100, 1) }}%)
                                            direkomendasikan untuk TKR
                                        @else
                                            Distribusi rekomendasi seimbang antara TKJ dan TKR
                                        @endif
                                    </li>
                                    <li>
                                        @if ($stats['rata_preferensi'] > 0.35)
                                            Rata-rata nilai preferensi tinggi
                                            ({{ number_format($stats['rata_preferensi'], 4) }})
                                        @elseif($stats['rata_preferensi'] > 0.25)
                                            Rata-rata nilai preferensi sedang
                                            ({{ number_format($stats['rata_preferensi'], 4) }})
                                        @else
                                            Rata-rata nilai preferensi rendah
                                            ({{ number_format($stats['rata_preferensi'], 4) }})
                                        @endif
                                    </li>
                                    <li>Rentang nilai: {{ number_format($stats['terendah'], 4) }} -
                                        {{ number_format($stats['tertinggi'], 4) }}</li>
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
        </div>
    @endif
</div>
