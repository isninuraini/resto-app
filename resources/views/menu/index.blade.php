@extends('layouts.app')

@section('content')
<div class="d-flex">
    @include('layouts.sidebar')

    <div class="container mt-5" style="margin-left: 270px;">

        {{-- === JUDUL TENGAH === --}}
        <h2 class="fw-bold mb-4 text-center">📋 Daftar Menu</h2>

        {{-- Tombol Tambah --}}
        <div class="mb-4 text-start">
            <a href="{{ route('menu.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Menu
            </a>
        </div>

        {{-- === ALERT SUKSES === --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- === GRID MENU === --}}
        @if($menucount > 0)
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="row g-4">
                        @foreach($menus as $menu)
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card h-100 shadow-sm menu-card">

                                    {{-- Gambar Menu --}}
                                    <div class="ratio ratio-4x3 bg-light rounded-top overflow-hidden">
                                        @php 
                                            $src = $menu->foto 
                                                ? asset('storage/' . $menu->foto) 
                                                : 'https://via.placeholder.com/600x450?text=No+Image'; 
                                        @endphp
                                        <img src="{{ $src }}" 
                                             alt="{{ $menu->namamenu }}" 
                                             class="w-100 h-100" 
                                             style="object-fit: cover;">
                                    </div>

                                    {{-- Isi Kartu --}}
                                    <div class="card-body d-flex flex-column">
                                        <h6 class="mb-1 fw-bold">{{ $menu->namamenu }}</h6>
                                        <div class="small text-muted mb-2">{{ $menu->kategori ?? '-' }}</div>
                                        <div class="fw-semibold mb-3">{{ $menu->harga_rupiah }}</div>

                                        {{-- Tombol Edit & Hapus --}}
                                        <div class="mt-auto d-flex justify-content-center gap-2">
                                            <a href="{{ route('menu.edit', $menu->idmenu) }}" 
                                               class="btn btn-sm btn-warning px-3">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('menu.destroy', $menu->idmenu) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Hapus menu ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger px-3">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-card-image display-1 text-muted"></i>
                <p class="text-muted mt-3">Belum ada menu yang ditambahkan 🪑</p>
                <a href="{{ route('menu.create') }}" class="btn btn-primary px-4">
                    <i class="bi bi-plus-circle"></i> Tambah Menu Pertama
                </a>
            </div>
        @endif
    </div>
</div>

{{-- Bootstrap Icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

@push('styles')
<style>
    /* === CARD STYLING === */
    .menu-card {
        border: none;
        border-radius: 12px;
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .menu-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
    }

    /* === RESPONSIF UNTUK MOBILE === */
    @media (max-width: 992px) {
        .container {
            margin-left: 0 !important;
        }
    }
</style>
@endpush
@endsection
