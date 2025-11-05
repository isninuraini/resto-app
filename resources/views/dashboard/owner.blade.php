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
            <h5 class="fw-bold text-white">Resto Owner</h5>
            <small class="text-white-50">Owner </small>
        </div>

        <ul class="nav flex-column mt-3">
            <li class="nav-item mb-2">
                <a href="{{ route('dashboard') }}" 
                   class="nav-link active d-flex align-items-center text-white">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('laporan.index') }}" 
                   class="nav-link d-flex align-items-center text-white">
                    <i class="bi bi-file-earmark-text me-2"></i> Laporan
                </a>
            </li>
        </ul>
    </div>

    {{-- === KONTEN UTAMA === --}}
    <div class="container py-5" style="margin-left: 270px;">

        {{-- === WELCOME BOX === --}}
        <div class="welcome-box text-center mb-5 p-4 rounded-4 shadow-sm"
            style="background: linear-gradient(90deg, #003366, #007bff); color: white;">
            <h2 class="fw-bold">Selamat Datang, {{ Auth::user()->namauser }} 👋</h2>
            <p class="mb-0">Pantau performa dan laporan keuangan restoranmu 📊</p>
        </div>

        {{-- === KARTU STATISTIK === --}}
        <div class="row justify-content-center g-4">

            {{-- Total Laporan --}}
            <div class="col-md-4">
                <div class="card glass-card text-center p-4">
                    <i class="bi bi-graph-up-arrow fs-1 text-success mb-2"></i>
                    <h5 class="fw-bold text-dark">Total Laporan</h5>
                    <h3 class="fw-bolder text-primary">{{ $totalLaporan }}</h3>
                </div>
            </div>

            {{-- Total Pendapatan --}}
            <div class="col-md-4">
                <div class="card glass-card text-center p-4">
                    <i class="bi bi-cash-stack fs-1 text-warning mb-2"></i>
                    <h5 class="fw-bold text-dark">Total Pendapatan</h5>
                    <h3 class="fw-bolder text-primary">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                </div>
            </div>

            {{-- Lihat Detail Laporan --}}
            <div class="col-md-4">
                <a href="{{ route('laporan.index') }}" class="text-decoration-none">
                    <div class="card glass-card text-center p-4">
                        <i class="bi bi-card-list fs-1 text-primary mb-2"></i>
                        <h5 class="fw-bold text-dark">Lihat Laporan Detail</h5>
                        <p class="text-muted mb-0">Klik untuk melihat laporan lengkap</p>
                    </div>
                </a>
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
