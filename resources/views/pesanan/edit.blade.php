@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 fw-bold">✏️ Edit Pesanan</h2>

    {{-- Alert Error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('pesanan.update', $pesanan->idpesanan) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Pilih Menu --}}
                <div class="mb-3">
                    <label for="idmenu" class="form-label fw-semibold">Menu</label>
                    <select name="idmenu" id="idmenu" class="form-select" required>
                        <option value="">-- Pilih Menu --</option>
                        @foreach($menus as $menu)
                            <option value="{{ $menu->idmenu }}" 
                                @if($menu->idmenu == $pesanan->idmenu) selected @endif>
                                {{ $menu->namamenu }} - Rp {{ number_format($menu->harga, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Pilih Pelanggan --}}
                <div class="mb-3">
                    <label for="idpelanggan" class="form-label fw-semibold">Pelanggan</label>
                    <select name="idpelanggan" id="idpelanggan" class="form-select" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach($pelanggans as $pelanggan)
                            <option value="{{ $pelanggan->idpelanggan }}" 
                                @if($pelanggan->idpelanggan == $pesanan->idpelanggan) selected @endif>
                                {{ $pelanggan->namapelanggan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Pilih Meja --}}
                <div class="mb-3">
                    <label for="idmeja" class="form-label fw-semibold">Meja</label>
                    <select name="idmeja" id="idmeja" class="form-select" required>
                        <option value="">-- Pilih Meja --</option>
                        @foreach($mejas as $meja)
                            <option value="{{ $meja->id }}" 
                                @if($meja->id == $pesanan->idmeja) selected @endif>
                                {{ $meja->nama }} (Kapasitas: {{ $meja->kapasitas }} orang)
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Jumlah --}}
                <div class="mb-3">
                    <label for="jumlah" class="form-label fw-semibold">Jumlah Makanan</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control" 
                           value="{{ $pesanan->jumlah }}" min="1" required>
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Tambahkan CDN Select2 --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

{{-- Aktifkan Select2 --}}
<script>
$(document).ready(function() {
    $('#idmenu').select2({
        placeholder: "-- Pilih Menu --",
        allowClear: true,
        tags: false // ❌ tidak bisa ketik manual
    });

    $('#idpelanggan').select2({
        placeholder: "-- Pilih Pelanggan --",
        allowClear: true,
        tags: false
    });

    $('#idmeja').select2({
        placeholder: "-- Pilih Meja --",
        allowClear: true,
        tags: false
    });
});
</script>

{{-- Bootstrap Icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection
