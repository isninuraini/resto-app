@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3 class="fw-bold mb-4">➕ Tambah Meja</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <h5>Terjadi kesalahan:</h5>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('meja.store') }}" method="POST">
        @csrf

        {{-- Nama --}}
        <div class="mb-3">
            <label class="form-label">Nama Meja</label>
            <input type="text" name="nama" class="form-control">
        </div>

        {{-- Nomor Meja --}}
        <div class="mb-3">
            <label class="form-label">Nomor Meja</label>
            <input type="number" name="nomor_meja" class="form-control">
        </div>

        {{-- Kapasitas --}}
        <div class="mb-3">
            <label class="form-label">Kapasitas</label>
            <input type="number" name="kapasitas" class="form-control">
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="tersedia">Tersedia</option>
                <option value="tidak_tersedia">Tidak Tersedia</option>
            </select>
        </div>

        {{-- Tanggal --}}
        <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>


        {{-- Tombol --}}
        <div class="d-flex justify-content-between">
            <a href="{{ route('meja.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan
            </button>
        </div>
    </form>
</div>

{{-- Bootstrap Icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection
