<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #2c3e50;
        }
        
        .header p {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #7f8c8d;
        }
        
        .info-section {
            margin-bottom: 25px;
        }
        
        .info-section h3 {
            background-color: #3498db;
            color: white;
            padding: 8px 12px;
            margin: 0 0 15px 0;
            font-size: 14px;
            border-radius: 4px;
        }
        
        .info-grid {
            width: 100%;
            margin-bottom: 15px;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 8px;
            padding: 5px 0;
        }
        
        .info-label {
            width: 30%;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .info-value {
            width: 70%;
            color: #34495e;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        .table th {
            background-color: #34495e;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }
        
        .table td {
            padding: 10px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 11px;
        }
        
        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .total-section {
            margin-top: 20px;
            padding: 15px;
            background-color: #ecf0f1;
            border-radius: 4px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        
        .total-label {
            font-weight: bold;
            color: #2c3e50;
        }
        
        .total-value {
            font-weight: bold;
            color: #27ae60;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-selesai {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN TRANSAKSI</h1>
        <p>Restaurant Management System</p>
        <p>Dicetak pada: {{ $tanggal_cetak }}</p>
    </div>

    <!-- Informasi Transaksi -->
    <div class="info-section">
        <h3>Informasi Transaksi</h3>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">ID Transaksi:</div>
                <div class="info-value">#{{ $transaksi->idtransaksi }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tanggal:</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($transaksi->created_at)->format('d F Y, H:i') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Status:</div>
                <div class="info-value">
                    <span class="status-badge status-selesai">Selesai</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Pelanggan -->
    <div class="info-section">
        <h3>Informasi Pelanggan</h3>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Nama:</div>
                <div class="info-value">{{ $transaksi->pesanan->pelanggan->namapelanggan ?? 'Tidak ada data' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Jenis Kelamin:</div>
                <div class="info-value">
                    @if($transaksi->pesanan->pelanggan->jeniskelamin == 'L')
                        Laki-laki
                    @elseif($transaksi->pesanan->pelanggan->jeniskelamin == 'P')
                        Perempuan
                    @else
                        -
                    @endif
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">No. Telepon:</div>
                <div class="info-value">{{ $transaksi->pesanan->pelanggan->no_telp ?? '-' }}</div>
            </div>
        </div>
    </div>

    <!-- Detail Pesanan -->
    <div class="info-section">
        <h3>Detail Pesanan</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Menu</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-right">Harga Satuan</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $transaksi->pesanan->menu->namamenu ?? 'Menu tidak ditemukan' }}</td>
                    <td class="text-center">{{ $transaksi->pesanan->jumlah }}</td>
                    <td class="text-right">Rp {{ number_format($transaksi->pesanan->menu->harga ?? 0, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Ringkasan Pembayaran -->
    <div class="total-section">
        <div class="total-row">
            <span class="total-label">Total Harga:</span>
            <span class="total-value">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
        </div>
        <div class="total-row">
            <span class="total-label">Jumlah Bayar:</span>
            <span class="total-value">Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</span>
        </div>
        <div class="total-row" style="border-top: 2px solid #bdc3c7; padding-top: 8px; margin-top: 8px;">
            <span class="total-label">Kembalian:</span>
            <span class="total-value">Rp {{ number_format($transaksi->bayar - $transaksi->total, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh Restaurant Management System</p>
        <p>Untuk pertanyaan, hubungi administrator sistem</p>
    </div>
</body>
</html>
