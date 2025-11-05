@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="bi bi-pencil"></i> Edit Transaksi
                    </h4>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('transaksi.update', $transaksi->idtransaksi) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted">Informasi Pesanan</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Nama Menu:</strong></td>
                                        <td>{{ $transaksi->pesanan->menu->namamenu }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Pelanggan:</strong></td>
                                        <td>{{ $transaksi->pesanan->pelanggan->namapelanggan }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jumlah:</strong></td>
                                        <td>{{ $transaksi->pesanan->jumlah }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Harga Satuan:</strong></td>
                                        <td>Rp {{ number_format($transaksi->pesanan->harga, 0, ',', '.') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Edit Transaksi</h6>
                                
                                <div class="mb-3">
                                    <label for="total" class="form-label">Total Harga</label>
                                    <input type="text" id="total" class="form-control" 
                                           value="Rp {{ number_format($transaksi->total, 0, ',', '.') }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="bayar" class="form-label">Jumlah Bayar</label>
                                    <input type="number" name="bayar" id="bayar" class="form-control" 
                                           value="{{ $transaksi->bayar }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="kembali" class="form-label">Kembalian</label>
                                    <input type="text" id="kembali" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('transaksi.show', $transaksi->idtransaksi) }}" class="btn btn-secondary me-md-2">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-check-circle"></i> Update Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const total = {{ $transaksi->total }};
    const bayarInput = document.getElementById('bayar');
    const kembaliInput = document.getElementById('kembali');

    function calculateKembali() {
        const bayar = parseFloat(bayarInput.value) || 0;
        const kembali = bayar - total;
        
        if (kembali >= 0) {
            kembaliInput.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(kembali);
            kembaliInput.classList.remove('is-invalid');
        } else {
            kembaliInput.value = 'Kurang Rp ' + new Intl.NumberFormat('id-ID').format(Math.abs(kembali));
            kembaliInput.classList.add('is-invalid');
        }
    }

    bayarInput.addEventListener('input', calculateKembali);
    calculateKembali(); // Initial calculation
});
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection

