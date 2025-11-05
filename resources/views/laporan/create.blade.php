@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Tambah Transaksi</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('laporan.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
            <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-control" 
                   value="{{ old('nama_pelanggan') }}" placeholder="Masukkan nama pelanggan" required>
            <small class="form-text text-muted">Pelanggan baru akan dibuat otomatis jika belum ada</small>
        </div>

        <div class="mb-3">
            <label for="idmenu" class="form-label">Menu</label>
            <select name="idmenu" id="idmenu" class="form-select" required>
                <option value="">-- Pilih Menu --</option>
                @foreach($menus as $menu)
                    <option value="{{ $menu->idmenu }}" 
                            data-harga="{{ $menu->harga }}"
                            {{ old('idmenu') == $menu->idmenu ? 'selected' : '' }}>
                        {{ $menu->namamenu }} - Rp {{ number_format($menu->harga,0,',','.') }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control" 
                   value="{{ old('jumlah', 1) }}" min="1" required>
        </div>
        
        <div class="mb-3">
            <label for="total" class="form-label">Total Harga</label>
            <input type="number" name="total" id="total" class="form-control" min="0" required>
            <small class="form-text text-muted">Total harga akan dihitung otomatis berdasarkan menu dan jumlah</small>
        </div>
        
        <div class="mb-3">
            <label for="bayar" class="form-label">Jumlah Bayar</label>
            <input type="number" name="bayar" id="bayar" class="form-control" min="0" required>
        </div>
        
        <div class="mb-3">
            <label for="kembalian" class="form-label">Kembalian</label>
            <input type="number" id="kembalian" class="form-control" readonly>
        </div>
        
        <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const idmenuSelect = document.getElementById('idmenu');
    const jumlahInput = document.getElementById('jumlah');
    const totalInput = document.getElementById('total');
    const bayarInput = document.getElementById('bayar');
    const kembalianInput = document.getElementById('kembalian');
    
    function calculateTotal() {
        if (idmenuSelect && idmenuSelect.value && jumlahInput) {
            const selectedOption = idmenuSelect.options[idmenuSelect.selectedIndex];
            const harga = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
            const jumlah = parseFloat(jumlahInput.value) || 0;
            const total = harga * jumlah;
            
            totalInput.value = total;
            calculateKembalian();
        } else {
            totalInput.value = 0;
            kembalianInput.value = 0;
        }
    }
    
    if (idmenuSelect) {
        idmenuSelect.addEventListener('change', calculateTotal);
    }
    
    if (jumlahInput) {
        jumlahInput.addEventListener('input', calculateTotal);
    }
    
    if (bayarInput) {
        bayarInput.addEventListener('input', calculateKembalian);
    }
    
    function calculateKembalian() {
        const total = parseFloat(totalInput.value) || 0;
        const bayar = parseFloat(bayarInput.value) || 0;
        const kembalian = bayar - total;
        kembalianInput.value = kembalian > 0 ? kembalian : 0;
    }
    
    // Hitung total saat halaman dimuat
    calculateTotal();
});
</script>
@endsection
    