@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3 class="fw-bold mb-4 text-center">✏️ Edit Data Meja</h3>

    {{-- Alert jika ada error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Edit --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('meja.update', $meja->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Meja</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama', $meja->nama) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor Meja</label>
                    <input type="number" name="nomor_meja" class="form-control" value="{{ old('nomor_meja', $meja->nomor_meja) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kapasitas</label>
                    <input type="number" name="kapasitas" class="form-control" value="{{ old('kapasitas', $meja->kapasitas) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="tersedia" {{ old('status', $meja->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="tidak_tersedia" {{ old('status', $meja->status) == 'tidak_tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $meja->tanggal) }}" required>
                </div>


                <div class="d-flex justify-content-between">
                    <a href="{{ route('meja.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left-circle"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Bootstrap Icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection
