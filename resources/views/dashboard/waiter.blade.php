@extends('layouts.app')

{{-- === SIDEBAR ADMIN === --}}
    @include('layouts.sidebar')

    
@section('content')
<div class="d-flex">

    {{-- === SIDEBAR === --}}
    <div class="sidebar p-3 d-flex flex-column"
        style="
            width: 270px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, #001f3f, #003366);
            color: #fff;
            z-index: 1000;
        ">
        <div class="text-center mb-4 mt-3">
            <img src="https://cdn-icons-png.flaticon.com/512/3075/3075977.png"
                 width="60"
                 class="mb-2">
            <h5 class="fw-bold text-white">Resto Waiter</h5>
            <small class="text-white-50">Waiter </small>
        </div>

        <ul class="nav flex-column mt-3">
            <li class="nav-item mb-2">
                <a href="{{ route('dashboard') }}"
                   class="nav-link active d-flex align-items-center text-white">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('menu.index') }}"
                   class="nav-link d-flex align-items-center text-white">
                    <i class="bi bi-journal-text me-2"></i> Kelola Menu
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('pelanggan.index') }}"
                   class="nav-link d-flex align-items-center text-white">
                    <i class="bi bi-people me-2"></i> Entri Pelanggan
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('pesanan.index') }}"
                   class="nav-link d-flex align-items-center text-white">
                    <i class="bi bi-receipt me-2"></i> Entri Pesanan
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('laporan.index') }}"
                   class="nav-link d-flex align-items-center text-white">
                    <i class="bi bi-card-list me-2"></i> Laporan
                </a>
            </li>
        </ul>
    </div>

    {{-- === KONTEN UTAMA === --}}
    <div class="container py-5" style="margin-left: 270px;">

        {{-- === UCAPAN SELAMAT DATANG === --}}
        <div class="welcome-box text-center mb-5 p-4 rounded-4 shadow-sm"
            style="background: linear-gradient(90deg, #003366, #007bff); color: white;">
            <h2 class="fw-bold">Selamat Datang, {{ $user->username }} 👋</h2>
            <p class="mb-0">Semangat melayani pelanggan hari ini! ☕</p>
        </div>

        {{-- === KARTU STATISTIK === --}}
        <div class="row justify-content-center g-4">

            {{-- Total Menu --}}
            <div class="col-md-3 col-sm-6">
                <div class="card glass-card text-center p-4">
                    <i class="bi bi-journal-text fs-1 text-primary mb-3"></i>
                    <h5 class="fw-bold text-dark mb-1">Total Menu</h5>
                    <h3 class="fw-bolder text-primary">{{ $totalMenu }}</h3>
                </div>
            </div>

            {{-- Total Pelanggan --}}
            <div class="col-md-3 col-sm-6">
                <div class="card glass-card text-center p-4">
                    <i class="bi bi-people fs-1 text-warning mb-3"></i>
                    <h5 class="fw-bold text-dark mb-1">Total Pelanggan</h5>
                    <h3 class="fw-bolder text-primary">{{ $totalPelanggan }}</h3>
                </div>
            </div>

            {{-- Total Pesanan --}}
            <div class="col-md-3 col-sm-6">
                <div class="card glass-card text-center p-4">
                    <i class="bi bi-receipt fs-1 text-success mb-3"></i>
                    <h5 class="fw-bold text-dark mb-1">Total Pesanan</h5>
                    <h3 class="fw-bolder text-primary">{{ $totalPesanan }}</h3>
                </div>
            </div>

            {{-- Total Laporan --}}
            <div class="col-md-3 col-sm-6">
                <div class="card glass-card text-center p-4">
                    <i class="bi bi-bar-chart-line fs-1 text-danger mb-3"></i>
                    <h5 class="fw-bold text-dark mb-1">Total Laporan</h5>
                    <h3 class="fw-bolder text-primary">{{ $totalLaporan }}</h3>
                </div>
            </div>

        </div>

    </div>
</div>

{{-- === STYLE === --}}
@push('styles')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #eef1f6;
    }

    /* Sidebar */
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

    /* Card style */
    .glass-card {
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: 0.3s;
    }
    .glass-card:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    }

    /* Animasi Welcome Box */
    .welcome-box {
        animation: fadeInDown 1s ease;
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection
