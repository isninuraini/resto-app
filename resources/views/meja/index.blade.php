@extends('layouts.app')

{{-- === SIDEBAR ADMIN === --}}
    @include('layouts.sidebar')
@section('content')

<div class="container mt-5">
    <h2 class="fw-bold mb-4 text-center">📋 Daftar Meja</h2>

    
        {{-- Tombol Tambah --}}
        <div class="mb-4 text-start">
            <a href="{{ route('meja.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Meja
            </a>
        </div>

    {{-- Alert Sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tabel --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Nomor Meja</th>
                        <th>Kapasitas</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mejas as $index => $meja)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $meja->nama }}</td>
                            <td>{{ $meja->nomor_meja }}</td>
                            <td>{{ $meja->kapasitas }}</td>
                            <td>
                                @if($meja->status == 'tersedia')
                                    <span class="badge bg-success">Tersedia</span>
                                @else
                                    <span class="badge bg-danger">Tidak Tersedia</span>
                                @endif
                            </td>
                            <td>{{ $meja->tanggal }}</td>
                            <td>
                                <a href="{{ route('meja.edit', $meja->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('meja.destroy', $meja->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data meja</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
