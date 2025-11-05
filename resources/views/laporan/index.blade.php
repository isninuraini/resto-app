@extends('layouts.app')

@section('content')

{{-- === SIDEBAR ADMIN === --}}
    @include('layouts.sidebar')
<div class="container mt-4">
    {{-- === JUDUL === --}}
    <div class="text-center mb-4">
        <h2 class="fw-bold">📊 Laporan Transaksi</h2>
        <p class="text-muted">Lihat, filter, dan cetak seluruh data transaksi</p>
    </div>

    {{-- === TOMBOL NAVIGASI === --}}
    <div class="d-flex flex-wrap gap-2 mb-3">
        

        @if($transaksis->count() > 0)
        <a href="{{ route('laporan-pdf.all', request()->query()) }}" class="btn text-white" style="background-color:#dc3545;">
            <i class="bi bi-file-earmark-pdf"></i> Cetak Semua PDF
        </a>
        @endif
    </div>

    {{-- === FILTER TANGGAL === --}}
    <form action="{{ route('laporan.index') }}" method="GET" class="row g-2 mb-4 align-items-end bg-light p-3 rounded shadow-sm">
        <div class="col-md-4">
            <label class="form-label fw-semibold">Dari Tanggal</label>
            <input type="date" name="from" class="form-control" value="{{ request('from') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">Sampai Tanggal</label>
            <input type="date" name="to" class="form-control" value="{{ request('to') }}">
        </div>
        <div class="col-md-4 d-flex gap-2 mt-2">
            {{-- Tombol Filter (Hijau) --}}
            <button type="submit" class="btn text-white flex-fill" style="background-color:#198754;">
                <i class="bi bi-funnel"></i> Filter
            </button>
            {{-- Tombol Reset (Oranye) --}}
            <a href="{{ route('laporan.index') }}" class="btn text-white flex-fill" style="background-color:#fd7e14;">
                <i class="bi bi-arrow-repeat"></i> Reset
            </a>
        </div>
    </form>

    {{-- === TABEL DATA === --}}
    @if($transaksis->count() > 0)
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>No</th>
                    <th>Pelanggan</th>
                    <th>Menu</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total</th>
                    <th>Bayar</th>
                    <th>Kembali</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksis as $transaksi)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $transaksi->pesanan->pelanggan->namapelanggan ?? '-' }}</td>
                    <td>{{ $transaksi->pesanan->menu->namamenu ?? '-' }}</td>
                    <td class="text-center">{{ $transaksi->pesanan->jumlah ?? '-' }}</td>
                    <td>Rp {{ number_format($transaksi->pesanan->menu->harga ?? 0, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($transaksi->bayar - $transaksi->total, 0, ',', '.') }}</td>
                    <td>{{ $transaksi->tgl->format('d-m-Y H:i') }}</td>
                    <td class="text-center">
                        <div class="d-flex flex-wrap justify-content-center gap-1">
                            {{-- Tombol Edit (Biru) --}}
                            <a href="{{ route('laporan.edit', $transaksi->idtransaksi) }}" 
                               class="btn btn-sm text-white" style="background-color:#0d6efd;">
                                <i class="bi bi-pencil"></i> Edit
                            </a>

                            {{-- Tombol PDF Per Transaksi (Merah tua) --}}
                            <a href="{{ route('laporan-pdf.single', $transaksi->idtransaksi) }}" 
                               class="btn btn-sm text-white" style="background-color:#b02a37;">
                                <i class="bi bi-file-earmark-pdf"></i> PDF
                            </a>

                            @if($transaksi->pesanan && $transaksi->pesanan->pelanggan)
                            {{-- Tombol Semua PDF per Pelanggan (Ungu) --}}
                            <a href="{{ route('laporan-pdf.by-pelanggan', $transaksi->pesanan->pelanggan->idpelanggan) }}" 
                               class="btn btn-sm text-white" style="background-color:#6f42c1;">
                                <i class="bi bi-files"></i> Semua PDF
                            </a>

                            {{-- Tombol Struk (Biru gelap) --}}
                            <a href="{{ route('receipt.print.by-pelanggan', $transaksi->pesanan->pelanggan->idpelanggan) }}" 
                               class="btn btn-sm text-white" style="background-color:#002b5c;">
                                <i class="bi bi-printer"></i> Struk
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- === TOTAL PENDAPATAN === --}}
    <div class="mt-4 text-end">
        <div class="d-inline-block px-4 py-3 rounded-3 shadow-sm fw-bold text-white" style="background-color:#002b5c;">
            💵 Total Pendapatan:
            <span class="text-warning">Rp {{ number_format($transaksis->sum('total'), 0, ',', '.') }}</span>
        </div>
    </div>

    @else
        <div class="text-center mt-5">
            <p class="text-muted">Belum ada transaksi.</p>
        </div>
    @endif
</div>

{{-- === Bootstrap Icons === --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection
