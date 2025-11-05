@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3 class="fw-bold mb-4">✏️ Edit Data Pelanggan</h3>

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

    <form action="{{ route('pelanggan.update', $pelanggan->idpelanggan) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="namapelanggan" class="form-label">Nama Pelanggan</label>
            <input type="text" name="namapelanggan" id="namapelanggan" class="form-control" 
                   value="{{ old('namapelanggan', $pelanggan->namapelanggan) }}" 
                   placeholder="Masukkan nama lengkap" required>
        </div>

        <div class="mb-3">
            <label for="jeniskelamin" class="form-label">Jenis Kelamin</label>
            <select name="jeniskelamin" id="jeniskelamin" class="form-select" required>
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="L" {{ old('jeniskelamin', $pelanggan->jeniskelamin) == 'L' ? 'selected' : '' }}>
                    Laki-laki
                </option>
                <option value="P" {{ old('jeniskelamin', $pelanggan->jeniskelamin) == 'P' ? 'selected' : '' }}>
                    Perempuan
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label for="no_telp" class="form-label">No. Telepon</label>
            <input type="text" name="no_telp" id="no_telp" class="form-control" 
                   value="{{ old('no_telp', $pelanggan->no_telp) }}" 
                   placeholder="Contoh: 081234567890" required>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" rows="3" 
                      placeholder="Masukkan alamat lengkap" required>{{ old('alamat', $pelanggan->alamat) }}</textarea>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Update Pelanggan
            </button>
        </div>
    </form>
</div>

{{-- Bootstrap Icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection



























