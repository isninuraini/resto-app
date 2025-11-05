@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Edit Transaksi</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('laporan.update', $laporan->idtransaksi) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="idpesanan" class="form-label">Pilih Pesanan</label>
            <select name="idpesanan" id="idpesanan" class="form-select" required>
                <option value="">-- Pilih Pesanan --</option>
                @foreach($pesanans as $pesanan)
                    <option value="{{ $pesanan->idpesanan }}" 
                            data-harga="{{ $pesanan->harga }}"
                            data-jumlah="{{ $pesanan->jumlah }}"
                            {{ $pesanan->idpesanan == $laporan->idpesanan ? 'selected' : '' }}>
                        {{ $pesanan->menu->namamenu ?? 'Menu tidak ditemukan' }} - 
                        {{ $pesanan->pelanggan->namapelanggan ?? 'Pelanggan tidak ditemukan' }} 
                        ({{ $pesanan->jumlah }}x)
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3">
            <label for="total" class="form-label">Total Harga</label>
            <input type="number" name="total" id="total" class="form-control" min="0" 
                   value="{{ $laporan->total }}" required>
            <small class="form-text text-muted">Total harga akan dihitung otomatis berdasarkan pesanan yang dipilih</small>
        </div>
        
        <div class="mb-3">
            <label for="bayar" class="form-label">Jumlah Bayar</label>
            <input type="number" name="bayar" id="bayar" class="form-control" min="0" 
                   value="{{ $laporan->bayar }}" required>
        </div>
        
        <div class="mb-3">
            <label for="kembalian" class="form-label">Kembalian</label>
            <input type="number" id="kembalian" class="form-control" readonly>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Transaksi</button>
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pesananSelect = document.getElementById('idpesanan');
    const totalInput = document.getElementById('total');
    const bayarInput = document.getElementById('bayar');
    const kembalianInput = document.getElementById('kembalian');
    
    // Hitung kembalian saat halaman dimuat
    calculateKembalian();
    
    // Hitung total otomatis saat pesanan dipilih
    pesananSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            const harga = parseFloat(selectedOption.dataset.harga) || 0;
            const jumlah = parseFloat(selectedOption.dataset.jumlah) || 0;
            const total = harga * jumlah;
            totalInput.value = total;
            calculateKembalian();
        } else {
            totalInput.value = '';
            kembalianInput.value = '';
        }
    });
    
    // Hitung kembalian saat bayar diubah
    bayarInput.addEventListener('input', calculateKembalian);
    
    function calculateKembalian() {
        const total = parseFloat(totalInput.value) || 0;
        const bayar = parseFloat(bayarInput.value) || 0;
        const kembalian = bayar - total;
        kembalianInput.value = kembalian >= 0 ? kembalian : 0;
    }
});
</script>
@endsection
