@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-plus-circle"></i> Tambah Transaksi
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

                    @if($pesanans->count() > 0)
                        <form action="{{ route('transaksi.store') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label">Pilih Pesanan (klik untuk memilih)</label>
                                <div class="border rounded p-2" style="max-height: 320px; overflow: auto;">
                                    @forelse($pesanans as $pesanan)
                                        <div class="form-check mb-1">
                                            <input class="form-check-input pesanan-checkbox" type="checkbox" 
                                                   name="idpesanan[]" id="psn_{{ $pesanan->idpesanan }}" 
                                                   value="{{ $pesanan->idpesanan }}" data-total="{{ $pesanan->harga }}">
                                            <label class="form-check-label" for="psn_{{ $pesanan->idpesanan }}">
                                                {{ $pesanan->pelanggan->namapelanggan }} - 
                                                {{ $pesanan->menu->namamenu }} ({{ $pesanan->jumlah }}x)
                                                — <strong>Rp {{ number_format($pesanan->harga, 0, ',', '.') }}</strong>
                                            </label>
                                        </div>
                                    @empty
                                        <div class="text-muted small">Tidak ada pesanan tersedia.</div>
                                    @endforelse
                                </div>
                                <div class="form-text">Gunakan klik mouse untuk memilih beberapa pesanan.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ringkasan Pesanan Terpilih</label>
                                <div id="ringkasan" class="border rounded p-2 bg-light small">Belum ada pesanan dipilih.</div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="total_semua" class="form-label">Total Semua</label>
                                    <input type="text" id="total_semua" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="bayar" class="form-label">Jumlah Uang</label>
                                    <input type="number" name="bayar" id="bayar" class="form-control" placeholder="Masukkan jumlah uang">
                                </div>
                                <div class="col-md-6">
                                    <label for="kembali" class="form-label">Kembalian</label>
                                    <input type="text" id="kembali" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('transaksi.index') }}" class="btn btn-secondary me-md-2">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Simpan Transaksi
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-exclamation-triangle display-1 text-warning"></i>
                            <h4 class="text-muted mt-3">Tidak ada pesanan yang tersedia</h4>
                            <p class="text-muted">Semua pesanan sudah memiliki transaksi</p>
                            <a href="{{ route('pesanan.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Buat Pesanan Baru
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.pesanan-checkbox');
    const ringkasanBox = document.getElementById('ringkasan');
    const totalSemuaInput = document.getElementById('total_semua');
    const bayarInput = document.getElementById('bayar');
    const kembaliInput = document.getElementById('kembali');

    function renderRingkasan() {
        const selected = Array.from(checkboxes).filter(cb => cb.checked);
        if (selected.length === 0) {
            ringkasanBox.innerHTML = 'Belum ada pesanan dipilih.';
            totalSemuaInput.value = '';
            kembaliInput.value = '';
            return;
        }
        let totalSemua = 0;
        let html = '<ul class="mb-2 ps-3">';
        selected.forEach(cb => {
            const label = document.querySelector('label[for="' + cb.id + '"]').innerText;
            const subtotal = parseFloat(cb.getAttribute('data-total')) || 0;
            totalSemua += subtotal;
            html += `<li>${label} ➜ <strong>Rp ${new Intl.NumberFormat('id-ID').format(subtotal)}</strong></li>`;
        });
        html += '</ul>';
        html += `<div>Total Semua: <strong>Rp ${new Intl.NumberFormat('id-ID').format(totalSemua)}</strong></div>`;
        ringkasanBox.innerHTML = html;
        totalSemuaInput.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalSemua);

        const bayar = parseFloat(bayarInput.value || 0);
        const kembali = bayar - totalSemua;
        if (!isNaN(kembali)) {
            if (kembali >= 0) {
                kembaliInput.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(kembali);
                kembaliInput.classList.remove('is-invalid');
            } else {
                kembaliInput.value = 'Kurang Rp ' + new Intl.NumberFormat('id-ID').format(Math.abs(kembali));
                kembaliInput.classList.add('is-invalid');
            }
        }
    }

    checkboxes.forEach(cb => cb.addEventListener('change', renderRingkasan));
    bayarInput.addEventListener('input', renderRingkasan);
    renderRingkasan();
});
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection

