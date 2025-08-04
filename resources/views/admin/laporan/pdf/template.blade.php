<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $laporan->judul_laporan }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 18px;
            color: #1e3a8a;
            margin: 0 0 5px 0;
        }

        .header h2 {
            font-size: 16px;
            color: #1e3a8a;
            margin: 0 0 10px 0;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .info-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .info-box h3 {
            margin: 0 0 10px 0;
            color: #1e3a8a;
            font-size: 14px;
        }

        .info-grid {
            width: 100%;
        }

        .info-row {
            margin-bottom: 5px;
        }

        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }

        .info-value {
            display: inline-block;
        }

        .stats-grid {
            width: 100%;
            margin-bottom: 20px;
        }

        .stats-row {
            display: flex;
            justify-content: space-between;
        }

        .stats-item {
            text-align: center;
            padding: 15px;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            width: 24%;
            margin-right: 1%;
        }

        .stats-item:last-child {
            margin-right: 0;
        }

        .stats-number {
            font-size: 24px;
            font-weight: bold;
            color: #1e3a8a;
            display: block;
        }

        .stats-label {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #1e3a8a;
            color: white;
            font-weight: bold;
            font-size: 11px;
        }

        td {
            font-size: 10px;
        }

        .text-center {
            text-align: center;
        }

        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }

        .badge-tkj {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .badge-tkr {
            background-color: #dcfce7;
            color: #166534;
        }

        .section {
            margin-bottom: 30px;
        }

        .section h3 {
            color: #1e3a8a;
            border-bottom: 1px solid #1e3a8a;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        .section h4 {
            color: #1e3a8a;
            margin-bottom: 10px;
            font-size: 12px;
        }

        .section h5 {
            color: #1e3a8a;
            margin-bottom: 8px;
            font-size: 11px;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 10px;
            color: #666;
        }

        .page-break {
            page-break-before: always;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }

        .flex {
            display: flex;
        }

        .justify-between {
            justify-content: space-between;
        }

        .mb-4 {
            margin-bottom: 16px;
        }

        .mt-4 {
            margin-top: 16px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>SISTEM PENDUKUNG KEPUTUSAN</h1>
        <h2>SMK Penida 2 Katapang</h2>
        <p>Jl. Raya Katapang No.123, Katapang, Kabupaten Bandung</p>
        <p>Telepon: (022) 123-4567 | Email: info@smkpenida2.sch.id</p>
    </div>

    <!-- Report Info -->
    <div class="info-box">
        <h3>Informasi Laporan</h3>
        <div class="info-grid">
            <div class="info-row">
                <span class="info-label">Judul Laporan:</span>
                <span class="info-value">{{ $laporan->judul_laporan }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Jenis Laporan:</span>
                <span class="info-value">{{ $laporan->jenis_laporan_indonesia }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tahun Ajaran:</span>
                <span class="info-value">{{ $laporan->tahun_ajaran }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Dibuat Oleh:</span>
                <span class="info-value">{{ $laporan->pembuatLaporan->full_name ?? 'Administrator' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal Dibuat:</span>
                <span class="info-value">{{ $laporan->created_at->format('d F Y, H:i') }} WIB</span>
            </div>
        </div>
    </div>

    <!-- Report Content Based on Type -->
    @if ($laporan->jenis_laporan === 'individual')
        @include('admin.laporan.pdf.individual', ['data' => $reportData])
    @elseif($laporan->jenis_laporan === 'ringkasan')
        @include('admin.laporan.pdf.summary', ['data' => $reportData])
    @elseif($laporan->jenis_laporan === 'perbandingan')
        @include('admin.laporan.pdf.comparison', ['data' => $reportData])
    @else
        <div class="no-data">
            <p>Jenis laporan tidak dikenali: {{ $laporan->jenis_laporan }}</p>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Digenerate pada: {{ now()->format('d F Y, H:i') }} WIB</p>
    </div>
</body>

</html>
