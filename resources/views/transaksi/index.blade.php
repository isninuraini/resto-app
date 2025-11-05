@extends('layouts.app')

@section('content')
    {{-- === SIDEBAR ADMIN === --}}
    @include('layouts.sidebar')

<div class="container mt-4">
    {{-- Judul di tengah --}}
    <div class="text-center mb-4">
        <h2 class="fw-bold">💰 Daftar Transaksi</h2>
    </div>

    {{-- Tombol navigasi --}}
    <div class="d-flex flex-wrap gap-2 mb-3">
        {{-- Tombol Kembali (abu-abu gelap) --}}
        
        </a>

        {{-- Tombol Tambah (hijau tua) --}}
        <a href="{{ route('transaksi.create') }}" class="btn text-white" style="background-color:#198754;">
            <i class="bi bi-plus-circle"></i> Tambah Transaksi
        </a>

        @if($transaksis->count() > 0)
        {{-- Tombol Cetak PDF (merah) --}}
        <a href="{{ route('laporan-pdf.all') }}" class="btn text-white" style="background-color:#dc3545;">
            <i class="bi bi-file-earmark-pdf"></i> Cetak Laporan PDF
        </a>
        @endif
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tabel data --}}
    @if($transaksis->count() > 0)
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Menu</th>
                    <th>Pelanggan</th>
                    <th>Jumlah</th>
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
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaksi->pesanan->menu->namamenu }}</td>
                    <td>{{ $transaksi->pesanan->pelanggan->namapelanggan }}</td>
                    <td>{{ $transaksi->pesanan->jumlah }}</td>
                    <td>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($transaksi->bayar - $transaksi->total, 0, ',', '.') }}</td>
                    <td>{{ $transaksi->tgl->format('d-m-Y H:i') }}</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center flex-wrap gap-1">
                            {{-- Detail (biru tua) --}}
                            <a href="{{ route('transaksi.show', $transaksi->idtransaksi) }}" 
                               class="btn btn-sm text-white" style="background-color:#0d6efd;" title="Detail">
                                <i class="bi bi-eye"></i> Detail
                            </a>

                            {{-- Edit (oranye) --}}
                            <a href="{{ route('transaksi.edit', $transaksi->idtransaksi) }}" 
                               class="btn btn-sm text-white" style="background-color:#fd7e14;" title="Edit">
                                <i class="bi bi-pencil"></i> Edit
                            </a>

                            {{-- PDF (merah tua) --}}
                            <a href="{{ route('laporan-pdf.single', $transaksi->idtransaksi) }}" 
                               class="btn btn-sm text-white" style="background-color:#b02a37;" title="Cetak PDF">
                                <i class="bi bi-file-earmark-pdf"></i> PDF
                            </a>

                            {{-- Hapus (hitam pekat) --}}
                            <form action="{{ route('transaksi.destroy', $transaksi->idtransaksi) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm text-white" style="background-color:#212529;" title="Hapus">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Bagian total pendapatan --}}
    <div class="mt-4 text-end">
        <div class="d-inline-block px-4 py-3 rounded-3 shadow-sm fw-bold text-white" 
             style="background-color:#002b5c;">
            💵 Total Pendapatan: 
            <span class="text-warning">
                Rp {{ number_format($transaksis->sum('total'), 0, ',', '.') }}
            </span>
        </div>
    </div>

    @else
        <p class="text-muted">Belum ada transaksi.</p>
    @endif
</div>

{{-- Bootstrap Icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection
