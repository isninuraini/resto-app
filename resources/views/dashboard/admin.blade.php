@extends('layouts.app')

@section('content')
<div class="d-flex">

    {{-- === SIDEBAR ADMIN === --}}
    @include('layouts.sidebar')

    {{-- === KONTEN UTAMA ADMIN === --}}
    <div class="container py-5" style="margin-left: 270px;">

        {{-- === UCAPAN SELAMAT DATANG === --}}
        <div class="welcome-box text-center mb-5 p-4 rounded-4 shadow-sm"
            style="background: linear-gradient(90deg, #003366, #007bff); color: white;">
            <h2 class="fw-bold">
                Selamat Datang, {{ $user->name ?? 'Admin' }} 👋
            </h2>
            <p class="mb-0">
                Semoga harimu menyenangkan dan penuh semangat mengelola restoran hari ini 🍽️
            </p>
        </div>

        {{-- === STATISTIK CARD === --}}
        <div class="row justify-content-center g-4">

            {{-- Card: Meja --}}
            <div class="col-md-4 col-lg-3">
                <div class="card glass-card text-center p-3">
                    <i class="bi bi-grid-3x3-gap fs-1 text-primary mb-3"></i>
                    <h5 class="fw-bold text-dark mb-1">Meja</h5>
                    <h3 class="fw-bold text-dark">{{ $totalMeja }}</h3>
                    <p class="text-muted small">Total meja terdaftar</p>
                </div>
            </div>

            {{-- Card: Menu / Barang --}}
            <div class="col-md-4 col-lg-3">
                <div class="card glass-card text-center p-3">
                    <i class="bi bi-box-seam fs-1 text-warning mb-3"></i>
                    <h5 class="fw-bold text-dark mb-1">Barang</h5>
                    <h3 class="fw-bold text-dark">{{ $totalMenu }}</h3>
                    <p class="text-muted small">Barang tersedia saat ini</p>
                </div>
            </div>

            {{-- Card: Pelanggan --}}
            <div class="col-md-4 col-lg-3">
                <div class="card glass-card text-center p-3">
                    <i class="bi bi-people fs-1 text-success mb-3"></i>
                    <h5 class="fw-bold text-dark mb-1">Pelanggan</h5>
                    <h3 class="fw-bold text-dark">{{ $totalPelanggan }}</h3>
                    <p class="text-muted small">Jumlah pelanggan aktif</p>
                </div>
            </div>

            {{-- Card: Transaksi --}}
            <div class="col-md-4 col-lg-3">
                <div class="card glass-card text-center p-3">
                    <i class="bi bi-cash-stack fs-1 text-danger mb-3"></i>
                    <h5 class="fw-bold text-dark mb-1">Transaksi</h5>
                    <h3 class="fw-bold text-dark">{{ $totalTransaksi }}</h3>
                    <p class="text-muted small">Total transaksi tercatat</p>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- === STYLES === --}}
@push('styles')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #eef1f6;
    }

    /* === Sidebar Link Style === */
    .nav-link {
        color: #fff !important;
        font-weight: 500;
        transition: all 0.3s ease;
        border-radius: 10px;
    }

    .nav-link:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: translateX(5px);
    }

    .nav-link.active {
        background: rgba(255, 255, 255, 0.35);
        font-weight: 600;
        box-shadow: inset 0 0 10px rgba(255, 255, 255, 0.2);
    }

    /* === Card Glass Style === */
    .glass-card {
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: 0.3s;
    }

    .glass-card:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    }

    /* === Animasi Welcome Box === */
    .welcome-box {
        animation: fadeInDown 1s ease;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

{{-- === ICONS === --}}
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection
