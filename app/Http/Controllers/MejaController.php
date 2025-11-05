<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    public function index()
    {
        $mejas = Meja::all();
        return view('meja.index', compact('mejas'));
    }

    public function create()
    {
        return view('meja.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'nomor_meja' => 'required|integer|min:1',
        'kapasitas' => 'required|integer|min:1',
        'tanggal' => 'required|date',
        'status' => 'required|in:tersedia,tidak_tersedia',
    ], [
        'nama.required' => 'Nama meja harus diisi.',
        'nama.string' => 'Nama meja harus berupa teks.',
        'nama.max' => 'Nama meja maksimal 255 karakter.',
        'nomor_meja.required' => 'Nomor meja harus diisi.',
        'nomor_meja.integer' => 'Nomor meja harus berupa angka.',
        'nomor_meja.min' => 'Nomor meja minimal 1.',
        'kapasitas.required' => 'Kapasitas harus diisi.',
        'kapasitas.integer' => 'Kapasitas harus berupa angka.',
        'kapasitas.min' => 'Kapasitas minimal 1.',
        'tanggal.required' => 'Tanggal harus diisi.',
        'tanggal.date' => 'Format tanggal tidak valid.',
        'status.required' => 'Status harus dipilih.',
        'status.in' => 'Status harus tersedia atau tidak tersedia.',
    ]);

    Meja::create($request->only(['nama', 'nomor_meja', 'kapasitas', 'tanggal', 'status']));

    return redirect()->route('meja.index')->with('success', 'Data meja berhasil ditambahkan!');
}



    public function edit(Meja $meja)
{
    return view('meja.edit', compact('meja'));
}

public function update(Request $request, Meja $meja)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'nomor_meja' => 'required|integer|min:1',
        'kapasitas' => 'required|integer|min:1',
        'tanggal' => 'required|date',
        'status' => 'required|in:tersedia,tidak_tersedia',
    ], [
        'nama.required' => 'Nama meja harus diisi.',
        'nama.string' => 'Nama meja harus berupa teks.',
        'nama.max' => 'Nama meja maksimal 255 karakter.',
        'nomor_meja.required' => 'Nomor meja harus diisi.',
        'nomor_meja.integer' => 'Nomor meja harus berupa angka.',
        'nomor_meja.min' => 'Nomor meja minimal 1.',
        'kapasitas.required' => 'Kapasitas harus diisi.',
        'kapasitas.integer' => 'Kapasitas harus berupa angka.',
        'kapasitas.min' => 'Kapasitas minimal 1.',
        'tanggal.required' => 'Tanggal harus diisi.',
        'tanggal.date' => 'Format tanggal tidak valid.',
        'status.required' => 'Status harus dipilih.',
        'status.in' => 'Status harus tersedia atau tidak tersedia.',
    ]);

    $meja->update($request->only(['nama', 'nomor_meja', 'kapasitas', 'tanggal', 'status']));

    return redirect()->route('meja.index')->with('success', 'Data meja berhasil diperbarui!');
}


    public function destroy(Meja $meja)
    {
        $meja->delete();
        return redirect()->route('meja.index')->with('success', 'Meja berhasil dihapus!');
    }
}
