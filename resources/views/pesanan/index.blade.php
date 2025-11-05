@extends('layouts.app')

@section('content')
<div class="d-flex">
    @include('layouts.sidebar')

    <div class="container mt-5" style="margin-left: 270px;">

        {{-- Judul Tengah --}}
        <h2 class="fw-bold text-center mb-4">📋 Daftar Pesanan</h2>

        {{-- Tombol di Kiri --}}
        <div class="mb-4 text-start">
            <a href="{{ route('pesanan.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Pesanan
            </a>
        </div>

        {{-- Alert Sukses --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Cek Data --}}
        @if($pesanans->count() > 0)
            @php
                $groupedPesanans = $pesanans->groupBy(function($item) {
                    return $item->idpelanggan . '-' . $item->idmeja;
                });
            @endphp

            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle shadow-sm">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>No</th>
                            <th>Pelanggan</th>
                            <th>Meja</th>
                            <th>Menu Dipesan</th>
                            <th>Total Jumlah</th>
                            <th>Total Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groupedPesanans as $key => $group)
                            @php
                                $first = $group->first();
                                $totalHarga = $group->sum('harga');
                                $totalJumlah = $group->sum('jumlah');
                            @endphp
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-start">{{ $first->pelanggan->namapelanggan }}</td>
                                <td>{{ $first->meja->nama ?? 'Tidak ada' }} ({{ $first->meja->kapasitas ?? '-' }} orang)</td>
                                <td class="text-start">
                                    <ul class="mb-0">
                                        @foreach($group as $pesanan)
                                            <li>{{ $pesanan->menu->namamenu }} ({{ $pesanan->jumlah }}x) - Rp {{ number_format($pesanan->harga, 0, ',', '.') }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ $totalJumlah }}</td>
                                <td><strong>Rp {{ number_format($totalHarga, 0, ',', '.') }}</strong></td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('pesanan.edit', $first->idpesanan) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('pesanan.destroy', $first->idpesanan) }}" method="POST" onsubmit="return confirm('Hapus semua pesanan pelanggan ini di meja ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
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
        @else
            <div class="text-center py-5">
                <i class="bi bi-card-list display-1 text-muted"></i>
                <p class="text-muted mt-3">Belum ada pesanan 📭</p>
                <a href="{{ route('pesanan.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Pesanan Pertama
                </a>
            </div>
        @endif
    </div>
</div>

{{-- Bootstrap Icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection
