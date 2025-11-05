<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Multiple Transaksi</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 11px;
            line-height: 1.3;
            margin: 0;
            padding: 15px;
            background: white;
        }
        
        .receipt-header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        
        .receipt-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 3px;
        }
        
        .receipt-subtitle {
            font-size: 12px;
            color: #666;
        }
        
        .summary-info {
            margin-bottom: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        
        .info-label {
            font-weight: bold;
        }
        
        .info-value {
            text-align: right;
        }
        
        .divider {
            border-top: 1px dashed #333;
            margin: 10px 0;
        }
        
        .transaction-item {
            margin-bottom: 15px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        
        .transaction-header {
            font-weight: bold;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            margin-bottom: 5px;
        }
        
        .item-details {
            font-size: 10px;
        }
        
        .item-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        
        .item-name {
            flex: 1;
        }
        
        .item-qty {
            width: 30px;
            text-align: center;
        }
        
        .item-price {
            width: 70px;
            text-align: right;
        }
        
        .transaction-total {
            border-top: 1px solid #ccc;
            padding-top: 5px;
            margin-top: 5px;
            font-weight: bold;
        }
        
        .grand-total {
            border-top: 2px solid #333;
            padding-top: 10px;
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
        }
        
        .receipt-footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px dashed #333;
        }
        
        .footer-text {
            font-size: 9px;
            color: #666;
            margin-bottom: 3px;
        }
    </style>
</head>
<body>
    <div class="receipt-header">
        <div class="receipt-title">RESTAURANT</div>
        <div class="receipt-subtitle">Laporan Transaksi</div>
    </div>

    <div class="summary-info">
        <div class="info-row">
            <span class="info-label">Tanggal Laporan:</span>
            <span class="info-value">{{ date('d/m/Y H:i') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Total Transaksi:</span>
            <span class="info-value">{{ $transaksis->count() }} transaksi</span>
        </div>
        <div class="info-row">
            <span class="info-label">Kasir:</span>
            <span class="info-value">{{ Auth::user()->namauser ?? 'Admin' }}</span>
        </div>
    </div>

    <div class="divider"></div>

    @php
        $totalPendapatan = 0;
    @endphp

    @foreach($transaksis as $index => $transaksi)
        <div class="transaction-item">
            <div class="transaction-header">
                Transaksi #{{ $transaksi->idtransaksi }} - {{ $transaksi->tgl->format('d/m/Y H:i') }}
            </div>
            
            <div class="item-details">
                <div class="item-row">
                    <span class="item-name">{{ $transaksi->pesanan->menu->namamenu ?? 'Menu' }}</span>
                    <span class="item-qty">{{ $transaksi->pesanan->jumlah ?? 0 }}</span>
                    <span class="item-price">Rp {{ number_format($transaksi->pesanan->harga ?? 0, 0, ',', '.') }}</span>
                </div>
                
                <div class="transaction-total">
                    <div class="item-row">
                        <span>Total: Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="item-row">
                        <span>Bayar: Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</span>
                    </div>
                    <div class="item-row">
                        <span>Kembalian: Rp {{ number_format($transaksi->bayar - $transaksi->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        @php
            $totalPendapatan += $transaksi->total;
        @endphp
    @endforeach

    <div class="grand-total">
        <div>Total Pendapatan: Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
    </div>

    <div class="receipt-footer">
        <div class="footer-text">Laporan ini dibuat secara otomatis</div>
        <div class="footer-text">Terima kasih atas kepercayaan Anda!</div>
    </div>
</body>
</html>
