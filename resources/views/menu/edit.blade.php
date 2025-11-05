@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit Menu</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('menu.update', $menu->idmenu) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Menu</label>
                    <input type="text" name="namamenu" value="{{ old('namamenu', $menu->namamenu) }}" 
                           class="form-control @error('namamenu') is-invalid @enderror" required>
                    @error('namamenu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" value="{{ old('harga', $menu->harga) }}" 
                           class="form-control @error('harga') is-invalid @enderror" required>
                    @error('harga')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="kategori" value="{{ old('kategori', $menu->kategori) }}" 
                           class="form-control @error('kategori') is-invalid @enderror" required>
                    @error('kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto</label>
                    <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if($menu->foto)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $menu->foto) }}" alt="Foto Menu" style="height: 80px; border-radius: 8px; object-fit: cover;">
                        </div>
                    @endif
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('menu.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
                
            </form>
        </div>
    </div>
</div>
@endsection
