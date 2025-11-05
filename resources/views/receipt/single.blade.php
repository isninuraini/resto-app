<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
            background: white;
        }
        
        .receipt-header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .receipt-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .receipt-subtitle {
            font-size: 14px;
            color: #666;
        }
        
        .receipt-info {
            margin-bottom: 20px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            padding: 2px 0;
        }
        
        .info-label {
            font-weight: bold;
        }
        
        .info-value {
            text-align: right;
        }
        
        .divider {
            border-top: 1px dashed #333;
            margin: 15px 0;
        }
        
        .item-details {
            margin: 15px 0;
        }
        
        .item-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            padding: 3px 0;
        }
        
        .item-name {
            font-weight: bold;
        }
        
        .item-qty {
            text-align: center;
            width: 30px;
        }
        
        .item-price {
            text-align: right;
            width: 80px;
        }
        
        .total-section {
            border-top: 2px solid #333;
            padding-top: 10px;
            margin-top: 15px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .grand-total {
            font-size: 14px;
            border-top: 1px solid #333;
            padding-top: 5px;
            margin-top: 10px;
        }
        
        .receipt-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px dashed #333;
        }
        
        .footer-text {
            font-size: 10px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .thank-you {
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="receipt-header">
        <div class="receipt-title">RESTAURANT</div>
        <div class="receipt-subtitle">Struk Transaksi</div>
    </div>

    <div class="receipt-info">
        <div class="info-row">
            <span class="info-label">No. Transaksi:</span>
            <span class="info-value">#{{ $transaksi->idtransaksi }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Tanggal:</span>
            <span class="info-value">{{ $transaksi->tgl->format('d/m/Y H:i') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Kasir:</span>
            <span class="info-value">{{ Auth::user()->namauser ?? 'Admin' }}</span>
        </div>
    </div>

    <div class="divider"></div>

    <div class="item-details">
        <div class="info-row" style="font-weight: bold; border-bottom: 1px solid #333; padding-bottom: 5px;">
            <span>Item</span>
            <span>Qty</span>
            <span>Harga</span>
        </div>
        
        <div class="item-row">
            <span class="item-name">{{ $transaksi->pesanan->menu->namamenu ?? 'Menu' }}</span>
            <span class="item-qty">{{ $transaksi->pesanan->jumlah ?? 0 }}</span>
            <span class="item-price">Rp {{ number_format($transaksi->pesanan->harga ?? 0, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="divider"></div>

    <div class="total-section">
        <div class="total-row">
            <span>Subtotal:</span>
            <span>Rp {{ number_format($transaksi->pesanan->harga * $transaksi->pesanan->jumlah, 0, ',', '.') }}</span>
        </div>
        <div class="total-row">
            <span>Total:</span>
            <span>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
        </div>
        <div class="total-row">
            <span>Bayar:</span>
            <span>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</span>
        </div>
        <div class="total-row grand-total">
            <span>Kembalian:</span>
            <span>Rp {{ number_format($transaksi->bayar - $transaksi->total, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="receipt-footer">
        <div class="footer-text">Terima kasih atas kunjungan Anda!</div>
        <div class="footer-text">Struk ini adalah bukti pembayaran yang sah</div>
        <div class="thank-you">SELAMAT MENIKMATI!</div>
    </div>
</body>
</html>
