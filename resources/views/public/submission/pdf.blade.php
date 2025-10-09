{{-- resources/views/public/submission/pdf.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Hasil Rekomendasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            border: 3px solid #1e3a8a;
            padding: 30px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 15px;
            background: #1e3a8a;
            border-radius: 50%;
        }

        h1 {
            color: #1e3a8a;
            font-size: 24px;
            margin: 10px 0;
        }

        .subtitle {
            color: #6b7280;
            font-size: 14px;
        }

        .section {
            margin: 20px 0;
            padding: 15px;
            background: #f9fafb;
            border-radius: 8px;
        }

        .section-title {
            color: #1e3a8a;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .data-row {
            display: table;
            width: 100%;
            margin: 8px 0;
        }

        .data-label {
            display: table-cell;
            width: 35%;
            color: #6b7280;
            padding-right: 10px;
        }

        .data-value {
            display: table-cell;
            font-weight: bold;
            color: #111827;
        }

        .result-box {
            text-align: center;
            padding: 20px;
            background: linear-gradient(to right, {{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? '#dbeafe, #bfdbfe' : '#d1fae5, #a7f3d0' }});
            border: 2px solid {{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? '#3b82f6' : '#10b981' }};
            border-radius: 8px;
            margin: 20px 0;
        }

        .result-title {
            font-size: 10px;
            color: #6b7280;
            margin-bottom: 5px;
        }

        .result-value {
            font-size: 22px;
            font-weight: bold;
            color: {{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? '#1e40af' : '#047857' }};
            margin: 5px 0;
        }

        .status-box {
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;

            @if ($penilaian->status_submission === 'approved')
                background: #d1fae5;
                border: 2px solid #10b981;
                color: #047857;
            @elseif($penilaian->status_submission === 'rejected')
                background: #fee2e2;
                border: 2px solid #ef4444;
                color: #991b1b;
            @else
                background: #fef3c7;
                border: 2px solid #f59e0b;
                color: #92400e;
            @endif
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
        }

        .signature-table {
            width: 100%;
            margin-top: 30px;
        }

        .signature-cell {
            width: 50%;
            text-align: center;
            padding: 10px;
        }

        .signature-line {
            border-top: 2px solid #111827;
            margin: 60px 30px 5px;
            padding-top: 5px;
            font-weight: bold;
        }

        .footer-note {
            text-align: center;
            color: #6b7280;
            font-size: 10px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo"></div>
            <h1>SERTIFIKAT HASIL REKOMENDASI</h1>
            <p class="subtitle">Sistem Pendukung Keputusan Pemilihan Jurusan</p>
            <p class="subtitle">SMK Penida 2 Katapang</p>
        </div>

        <!-- Data Peserta -->
        <div class="section">
            <div class="section-title">Data Peserta Didik</div>
            <div class="data-row">
                <span class="data-label">Nama Lengkap</span>
                <span class="data-value">{{ $pesertaDidik->nama_lengkap }}</span>
            </div>
            <div class="data-row">
                <span class="data-label">NISN</span>
                <span class="data-value">{{ $pesertaDidik->nisn }}</span>
            </div>
            <div class="data-row">
                <span class="data-label">Jenis Kelamin</span>
                <span class="data-value">{{ $pesertaDidik->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
            </div>
            <div class="data-row">
                <span class="data-label">Tahun Ajaran</span>
                <span class="data-value">{{ $pesertaDidik->tahun_ajaran }}</span>
            </div>
        </div>

        <!-- Hasil Rekomendasi -->
        <div class="result-box">
            <div class="result-title">Berdasarkan Metode TOPSIS, Anda Direkomendasikan:</div>
            <div class="result-value">
                {{ $perhitungan->jurusan_rekomendasi === 'TKJ' ? 'TEKNIK KOMPUTER DAN JARINGAN' : 'TEKNIK KENDARAAN RINGAN' }}
            </div>
            <div style="font-size: 16px; font-weight: bold; color: #6b7280;">
                ({{ $perhitungan->jurusan_rekomendasi }})
            </div>

            <table style="width: 100%; margin-top: 15px;">
                <tr>
                    <td
                        style="width: 50%; text-align: center; padding: 10px; background: white; border-radius: 8px; margin: 5px;">
                        <div style="font-size: 10px; color: #6b7280;">Nilai Preferensi</div>
                        <div style="font-size: 18px; font-weight: bold; color: #1e3a8a;">
                            {{ number_format($perhitungan->nilai_preferensi, 4) }}</div>
                    </td>
                    <td
                        style="width: 50%; text-align: center; padding: 10px; background: white; border-radius: 8px; margin: 5px;">
                        <div style="font-size: 10px; color: #6b7280;">Tingkat Kesesuaian</div>
                        <div style="font-size: 18px; font-weight: bold; color: #1e3a8a;">
                            {{ number_format($perhitungan->nilai_preferensi * 100, 1) }}%</div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Status -->
        <div class="status-box">
            <div style="font-weight: bold; margin-bottom: 10px;">
                STATUS KONFIRMASI:
                @if ($penilaian->status_submission === 'approved')
                    DISETUJUI
                @elseif($penilaian->status_submission === 'rejected')
                    TIDAK DISETUJUI
                @else
                    PENDING
                @endif
            </div>

            @if ($penilaian->status_submission === 'approved')
                <p>Peserta didik menyetujui rekomendasi ini</p>
            @elseif($penilaian->status_submission === 'rejected')
                <p>Peserta didik memilih jurusan: <strong>{{ $penilaian->jurusan_dipilih }}</strong></p>
                <p style="margin-top: 5px;">Alasan: {{ $penilaian->alasan_penolakan }}</p>
            @endif

            <p style="margin-top: 10px; font-size: 10px;">
                Tanggal:
                @if ($penilaian->tanggal_approved)
                    @php
                        $tanggalApproved =
                            $penilaian->tanggal_approved instanceof \Carbon\Carbon
                                ? $penilaian->tanggal_approved
                                : \Carbon\Carbon::parse($penilaian->tanggal_approved);
                    @endphp
                    {{ $tanggalApproved->format('d F Y, H:i') }}
                @else
                    {{ now()->format('d F Y, H:i') }}
                @endif
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <table class="signature-table">
                <tr>
                    <td class="signature-cell">
                        <p style="margin-bottom: 5px;">Mengetahui,</p>
                        <div class="signature-line">
                            Kepala Sekolah
                        </div>
                    </td>
                    <td class="signature-cell">
                        <p style="margin-bottom: 5px;">Peserta Didik,</p>
                        <div class="signature-line">
                            {{ $pesertaDidik->nama_lengkap }}
                        </div>
                    </td>
                </tr>
            </table>

            <div class="footer-note">
                <p>Dokumen ini digenerate secara otomatis oleh Sistem Pendukung Keputusan</p>
                <p>SMK Penida 2 Katapang © {{ date('Y') }}</p>
            </div>
        </div>
    </div>
</body>

</html>
