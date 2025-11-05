@extends('layouts.app')

@section('content')
<div class="d-flex">
    @include('layouts.sidebar')

    <div class="container mt-5" style="margin-left: 270px;">
        <h2 class="fw-bold text-center mb-4">👥 Daftar Pelanggan</h2>

        <div class="mb-4 text-start">
            <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Pelanggan
            </a>
        </div>

        @if($pelanggans->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle shadow-sm">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Jenis Kelamin</th>
                            <th>No. Telepon</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pelanggans as $pelanggan)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-start">{{ $pelanggan->namapelanggan }}</td>
                                <td>
                                    @if($pelanggan->jeniskelamin == 'L')
                                        <span class="badge bg-primary">Laki-laki</span>
                                    @elseif($pelanggan->jeniskelamin == 'P')
                                        <span class="badge bg-pink">Perempuan</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak Diketahui</span>
                                    @endif
                                </td>
                                <td>{{ $pelanggan->no_telp }}</td>
                                <td class="text-start">{{ Str::limit($pelanggan->alamat, 30) }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('pelanggan.edit', $pelanggan->idpelanggan) }}" 
                                           class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('pelanggan.destroy', $pelanggan->idpelanggan) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Hapus pelanggan ini?')">
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
                <i class="bi bi-person-x display-1 text-muted"></i>
                <p class="text-muted mt-3">Belum ada pelanggan terdaftar</p>
                <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Pelanggan Pertama
                </a>
            </div>
        @endif
    </div>
</div>

<style>
    .badge.bg-pink {
        background-color: #ff4da6 !important;
        color: #fff;
        font-weight: 600;
    }
</style>
@endsection
