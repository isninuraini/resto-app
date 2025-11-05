@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                {{-- === HEADER CARD === --}}
                <div class="card-header text-white" style="background-color: #002b5c;">
                    <h4 class="mb-0">
                        <i class="bi bi-receipt"></i> Detail Transaksi
                    </h4>
                </div>

                {{-- === ISI CARD === --}}
                <div class="card-body">
                    <div class="row">
                        {{-- KIRI: Info Pesanan --}}
                        <div class="col-md-6">
                            <h6 class="text-muted">Informasi Pesanan</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Nama Menu:</strong></td>
                                    <td>{{ $transaksi->pesanan->menu->namamenu }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Pelanggan:</strong></td>
                                    <td>{{ $transaksi->pesanan->pelanggan->namapelanggan }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah:</strong></td>
                                    <td>{{ $transaksi->pesanan->jumlah }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Harga Satuan:</strong></td>
                                    <td>Rp {{ number_format($transaksi->pesanan->harga, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>

                        {{-- KANAN: Info Transaksi --}}
                        <div class="col-md-6">
                            <h6 class="text-muted">Informasi Transaksi</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Total Harga:</strong></td>
                                    <td>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah Bayar:</strong></td>
                                    <td>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kembalian:</strong></td>
                                    <td class="text-success">
                                        <strong>Rp {{ number_format($transaksi->bayar - $transaksi->total, 0, ',', '.') }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal:</strong></td>
                                    <td>{{ $transaksi->tgl->format('d-m-Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    {{-- === TOMBOL AKSI === --}}
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('transaksi.index') }}" class="btn text-white me-md-2" style="background-color: #002b5c;">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('laporan-pdf.single', $transaksi->idtransaksi) }}" class="btn text-white me-md-2" style="background-color: #002b5c;">
                            <i class="bi bi-file-earmark-pdf"></i> Cetak PDF
                        </a>
                        <a href="{{ route('transaksi.edit', $transaksi->idtransaksi) }}" class="btn text-white me-md-2" style="background-color: #002b5c;">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('transaksi.destroy', $transaksi->idtransaksi) }}" 
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn text-white" style="background-color: #002b5c;">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection
