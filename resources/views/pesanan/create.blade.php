@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 fw-bold text-primary">🧾 Buat Pesanan Baru</h2>

    {{-- Alert Error --}}
    @if ($errors->any())
        <div class="alert alert-danger shadow-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="bi bi-exclamation-circle-fill"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('pesanan.store') }}" method="POST">
                @csrf

                {{-- Pilih Pelanggan --}}
                <div class="mb-3">
                    <label for="idpelanggan" class="form-label fw-semibold">Pelanggan</label>
                    <select name="idpelanggan" id="idpelanggan" class="form-select" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach($pelanggans as $pelanggan)
                            <option value="{{ $pelanggan->idpelanggan }}" {{ old('idpelanggan') == $pelanggan->idpelanggan ? 'selected' : '' }}>
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
                            <option value="{{ $meja->id }}" {{ old('idmeja') == $meja->id ? 'selected' : '' }}>
                                {{ $meja->nama }} (Kapasitas: {{ $meja->kapasitas }} orang)
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Pilih Menu --}}
                <div class="mb-3">
                    <label for="idmenu" class="form-label fw-semibold">Menu</label>
                    <select name="idmenu[]" id="idmenu" class="form-select" multiple required>
                        @foreach($menus as $menu)
                            <option value="{{ $menu->idmenu }}" {{ (collect(old('idmenu'))->contains($menu->idmenu)) ? 'selected' : '' }}>
                                {{ $menu->namamenu }} - Rp {{ number_format($menu->harga, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text">Tekan <strong>Ctrl</strong> (atau <strong>Cmd</strong> di Mac) untuk memilih lebih dari satu menu.</div>
                </div>

                {{-- Jumlah per menu --}}
                <div id="jumlah-container" class="mb-3"></div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('pesanan.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left-circle"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Buat Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Select2 & jQuery --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

{{-- Bootstrap Icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<script>
$(document).ready(function() {
    // Aktifkan Select2
    $('#idpelanggan, #idmeja').select2({
        placeholder: "-- Pilih --",
        allowClear: true,
        width: '100%'
    });

    $('#idmenu').select2({
        placeholder: "-- Pilih Satu atau Lebih Menu --",
        allowClear: true,
        width: '100%'
    });

    function renderJumlah() {
        let selectedMenus = $('#idmenu').val();
        let container = $('#jumlah-container');
        container.empty();

        if (selectedMenus && selectedMenus.length > 0) {
            selectedMenus.forEach(menuId => {
                let menuText = $('#idmenu option[value="'+menuId+'"]').text();
                let oldValue = '{{ old('jumlah') }}';
                container.append(`
                    <div class="mb-2">
                        <label class="form-label fw-semibold">Jumlah untuk ${menuText}</label>
                        <input type="number" name="jumlah[${menuId}]" class="form-control" value="1" min="1" required>
                    </div>
                `);
            });
        }
    }

    // Trigger saat select menu berubah
    $('#idmenu').on('change', renderJumlah);

    // Render jumlah saat page load (untuk old value)
    renderJumlah();
});
</script>
@endsection
