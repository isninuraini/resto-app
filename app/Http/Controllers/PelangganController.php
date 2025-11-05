<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::all();
        return view('pelanggan.index', compact('pelanggans'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'namapelanggan' => 'required|string|max:100',
            'jeniskelamin' => 'required|in:L,P',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
        ], [
            'namapelanggan.required' => 'Nama pelanggan harus diisi.',
            'namapelanggan.string' => 'Nama pelanggan harus berupa teks.',
            'namapelanggan.max' => 'Nama pelanggan maksimal 100 karakter.',
            'jeniskelamin.required' => 'Jenis kelamin harus dipilih.',
            'jeniskelamin.in' => 'Jenis kelamin harus Laki-laki atau Perempuan.',
            'no_telp.required' => 'No. telepon harus diisi.',
            'no_telp.string' => 'No. telepon harus berupa teks.',
            'no_telp.max' => 'No. telepon maksimal 20 karakter.',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'alamat.max' => 'Alamat maksimal 255 karakter.',
        ]);

        Pelanggan::create($request->all());
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'namapelanggan' => 'required|string|max:100',
            'jeniskelamin' => 'required|in:L,P',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
        ], [
            'namapelanggan.required' => 'Nama pelanggan harus diisi.',
            'namapelanggan.string' => 'Nama pelanggan harus berupa teks.',
            'namapelanggan.max' => 'Nama pelanggan maksimal 100 karakter.',
            'jeniskelamin.required' => 'Jenis kelamin harus dipilih.',
            'jeniskelamin.in' => 'Jenis kelamin harus Laki-laki atau Perempuan.',
            'no_telp.required' => 'No. telepon harus diisi.',
            'no_telp.string' => 'No. telepon harus berupa teks.',
            'no_telp.max' => 'No. telepon maksimal 20 karakter.',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'alamat.max' => 'Alamat maksimal 255 karakter.',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($request->all());
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Pelanggan::destroy($id);
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus!');
    }
}
