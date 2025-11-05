<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #333; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 18px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 20px; color: #2c3e50; }
        .meta { font-size: 10px; color: #7f8c8d; }
        .info { margin-bottom: 12px; }
        .info .row { display: flex; margin-bottom: 6px; }
        .info .label { width: 28%; font-weight: bold; color: #2c3e50; }
        .info .value { width: 72%; color: #34495e; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #34495e; color: #fff; padding: 8px 6px; text-align: left; font-size: 10px; }
        td { padding: 7px 6px; border-bottom: 1px solid #ddd; font-size: 10px; }
        tr:nth-child(even) { background: #f8f9fa; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .summary { margin-top: 14px; padding: 10px; background: #ecf0f1; border-radius: 4px; }
        .summary .row { display: flex; justify-content: space-between; margin-bottom: 6px; }
        .summary .label { font-weight: bold; color: #2c3e50; }
        .summary .value { font-weight: bold; color: #27ae60; }
        .footer { margin-top: 18px; text-align: center; font-size: 9px; color: #7f8c8d; border-top: 1px solid #ddd; padding-top: 8px; }
    </style>
    </head>
<body>
    <div class="header">
        <h1>LAPORAN TRANSAKSI PELANGGAN</h1>
        <div class="meta">Dicetak pada: {{ $tanggal_cetak }}</div>
    </div>

    <div class="info">
        <div class="row"><div class="label">Nama Pelanggan</div><div class="value">{{ $pelanggan->namapelanggan }}</div></div>
        <div class="row"><div class="label">Jumlah Item</div><div class="value">{{ $total_transaksi }}</div></div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 20%">Tanggal</th>
                <th style="width: 35%">Menu</th>
                <th style="width: 10%" class="text-center">Jumlah</th>
                <th style="width: 15%" class="text-right">Harga Satuan</th>
                <th style="width: 20%" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $p)
                <tr>
                    <td>{{ \Carbon\Carbon::parse(($p->transaksi->created_at ?? $p->created_at))->format('d/m/Y H:i') }}</td>
                    <td>{{ $p->menu->namamenu ?? '-' }}</td>
                    <td class="text-center">{{ $p->jumlah }}</td>
                    <td class="text-right">Rp {{ number_format($p->menu->harga ?? 0, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format(($p->transaksi->total ?? $p->harga), 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada transaksi untuk pelanggan ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <div class="row"><div class="label">Total Pendapatan</div><div class="value">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</div></div>
    </div>

    <div class="footer">
        Dokumen ini dibuat otomatis oleh Restaurant Management System
    </div>
</body>
</html>


