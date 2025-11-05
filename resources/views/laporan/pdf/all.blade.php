<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            line-height: 1.3;
            color: #333;
            margin: 0;
            padding: 15px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #2c3e50;
        }
        
        .header p {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: #7f8c8d;
        }
        
        .filter-info {
            background-color: #ecf0f1;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 11px;
        }
        
        .summary-cards {
            display: flex;
            width: 100%;
            margin-bottom: 20px;
            gap: 10px;
        }
        
        .summary-card {
            flex: 1;
            text-align: center;
            padding: 15px 10px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
        }
        
        .summary-number {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .summary-label {
            font-size: 10px;
            color: #6c757d;
            text-transform: uppercase;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        .table th {
            background-color: #34495e;
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            font-size: 9px;
            border: 1px solid #2c3e50;
        }
        
        .table td {
            padding: 6px;
            border: 1px solid #ddd;
            font-size: 9px;
            vertical-align: top;
        }
        
        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .table tr:hover {
            background-color: #e8f4f8;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-left {
            text-align: left;
        }
        
        .total-section {
            margin-top: 20px;
            padding: 15px;
            background-color: #2c3e50;
            color: white;
            border-radius: 4px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 12px;
        }
        
        .total-label {
            font-weight: bold;
        }
        
        .total-value {
            font-weight: bold;
            color: #27ae60;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #7f8c8d;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .status-badge {
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-selesai {
            background-color: #d4edda;
            color: #155724;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #6c757d;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN SEMUA TRANSAKSI</h1>
        <p>Restaurant Management System</p>
        <p>Dicetak pada: {{ $tanggal_cetak }}</p>
    </div>

    <!-- Filter Information -->
    @if($tanggal_mulai || $tanggal_akhir)
    <div class="filter-info">
        <strong>Filter Tanggal:</strong>
        @if($tanggal_mulai)
            Dari: {{ \Carbon\Carbon::parse($tanggal_mulai)->format('d F Y') }}
        @endif
        @if($tanggal_mulai && $tanggal_akhir)
            -
        @endif
        @if($tanggal_akhir)
            Sampai: {{ \Carbon\Carbon::parse($tanggal_akhir)->format('d F Y') }}
        @endif
    </div>
    @endif

    <!-- Summary Cards -->
    <div class="summary-cards">
        <div class="summary-card">
            <div class="summary-number">{{ $total_transaksi }}</div>
            <div class="summary-label">Total Transaksi</div>
        </div>
        <div class="summary-card">
            <div class="summary-number">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</div>
            <div class="summary-label">Total Pendapatan</div>
        </div>
        <div class="summary-card">
            <div class="summary-number">Rp {{ $total_transaksi > 0 ? number_format($total_pendapatan / $total_transaksi, 0, ',', '.') : '0' }}</div>
            <div class="summary-label">Rata-rata per Transaksi</div>
        </div>
        <div class="summary-card">
            <div class="summary-number">{{ $transaksis->where('created_at', '>=', now()->startOfDay())->count() }}</div>
            <div class="summary-label">Transaksi Hari Ini</div>
        </div>
    </div>

    <!-- Data Transaksi -->
    @if($transaksis->count() > 0)
    <table class="table">
        <thead>
            <tr>
                <th style="width: 8%;">ID</th>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 15%;">Pelanggan</th>
                <th style="width: 20%;">Menu</th>
                <th style="width: 8%;">Jumlah</th>
                <th style="width: 10%;">Harga Satuan</th>
                <th style="width: 10%;">Total</th>
                <th style="width: 10%;">Bayar</th>
                <th style="width: 7%;">Kembalian</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $index => $transaksi)
                @if($index > 0 && $index % 25 == 0)
                    </tbody>
                    </table>
                    <div class="page-break"></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 8%;">ID</th>
                                <th style="width: 12%;">Tanggal</th>
                                <th style="width: 15%;">Pelanggan</th>
                                <th style="width: 20%;">Menu</th>
                                <th style="width: 8%;">Jumlah</th>
                                <th style="width: 10%;">Harga Satuan</th>
                                <th style="width: 10%;">Total</th>
                                <th style="width: 10%;">Bayar</th>
                                <th style="width: 7%;">Kembalian</th>
                            </tr>
                        </thead>
                        <tbody>
                @endif
                <tr>
                    <td class="text-center">#{{ $transaksi->idtransaksi }}</td>
                    <td>{{ \Carbon\Carbon::parse($transaksi->created_at)->format('d/m/Y H:i') }}</td>
                    <td>{{ $transaksi->pesanan->pelanggan->namapelanggan ?? '-' }}</td>
                    <td>{{ $transaksi->pesanan->menu->namamenu ?? '-' }}</td>
                    <td class="text-center">{{ $transaksi->pesanan->jumlah }}</td>
                    <td class="text-right">Rp {{ number_format($transaksi->pesanan->menu->harga ?? 0, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($transaksi->bayar - $transaksi->total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-data">
        <p>Tidak ada data transaksi untuk periode yang dipilih.</p>
    </div>
    @endif

    <!-- Total Summary -->
    @if($transaksis->count() > 0)
    <div class="total-section">
        <div class="total-row">
            <span class="total-label">Total Transaksi:</span>
            <span class="total-value">{{ $total_transaksi }} transaksi</span>
        </div>
        <div class="total-row">
            <span class="total-label">Total Pendapatan:</span>
            <span class="total-value">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</span>
        </div>
        <div class="total-row">
            <span class="total-label">Rata-rata per Transaksi:</span>
            <span class="total-value">Rp {{ $total_transaksi > 0 ? number_format($total_pendapatan / $total_transaksi, 0, ',', '.') : '0' }}</span>
        </div>
    </div>
    @endif

    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh Restaurant Management System</p>
        <p>Untuk pertanyaan, hubungi administrator sistem</p>
    </div>
</body>
</html>
