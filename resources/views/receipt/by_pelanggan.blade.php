<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pelanggan</title>
    <style>
        body { font-family: 'Courier New', monospace; font-size: 12px; line-height: 1.35; margin: 0; padding: 18px; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 12px; }
        .title { font-size: 18px; font-weight: bold; }
        .subtitle { font-size: 12px; color: #666; }
        .info { margin-bottom: 10px; }
        .row { display: flex; justify-content: space-between; margin-bottom: 4px; }
        .label { font-weight: bold; }
        .divider { border-top: 1px dashed #333; margin: 10px 0; }
        .item-header, .item-row { display: flex; justify-content: space-between; }
        .item-header { font-weight: bold; border-bottom: 1px solid #333; padding-bottom: 5px; }
        .item-name { flex: 1; }
        .item-qty { width: 40px; text-align: center; }
        .item-price { width: 90px; text-align: right; }
        .total { border-top: 2px solid #333; padding-top: 8px; margin-top: 10px; }
        .footer { text-align: center; margin-top: 16px; padding-top: 10px; border-top: 1px dashed #333; font-size: 11px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">RESTAURANT</div>
        <div class="subtitle">Struk Pesanan Pelanggan</div>
    </div>

    <div class="info">
        <div class="row"><span class="label">Pelanggan</span><span>{{ $pelanggan->namapelanggan }}</span></div>
        <div class="row"><span class="label">Dicetak</span><span>{{ date('d/m/Y H:i') }}</span></div>
        <div class="row"><span class="label">Kasir</span><span>{{ Auth::user()->namauser ?? 'Admin' }}</span></div>
    </div>

    <div class="divider"></div>

    <div class="item-header">
        <span class="item-name">Item</span>
        <span class="item-qty">Qty</span>
        <span class="item-price">Subtotal</span>
    </div>

    @php $totalSemua = 0; @endphp
    @forelse($items as $p)
        @php
            $subtotal = (int) ($p->transaksi->total ?? $p->harga);
            $totalSemua += $subtotal;
        @endphp
        <div class="item-row">
            <span class="item-name">{{ $p->menu->namamenu ?? 'Menu' }}</span>
            <span class="item-qty">{{ $p->jumlah }}</span>
            <span class="item-price">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>
    @empty
        <div class="row"><span>Tidak ada item</span></div>
    @endforelse

    <div class="total">
        <div class="row"><span class="label">Total</span><span>Rp {{ number_format($totalSemua, 0, ',', '.') }}</span></div>
    </div>

    <div class="footer">
        Terima kasih atas kunjungan Anda!
    </div>
</body>
</html>




