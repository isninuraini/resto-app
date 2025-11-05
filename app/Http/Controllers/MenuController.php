<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // Tampilkan daftar menu
    public function index()
    {
        $menucount = Menu::count();
        $menus = Menu::all();
        return view('menu.index', compact('menus', 'menucount'));
    }

    // Tampilkan form tambah menu
    public function create()
    {
        return view('menu.create');
    }

    // Simpan menu baru
    public function store(Request $request)
    {
        // Validasi input sesuai kolom database
        $request->validate([
            'namamenu' => 'required|string|max:100',
            'harga' => 'required|numeric',
            'kategori' => 'required|string|max:50',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Handle upload foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('menu', 'public');
        }

        // Buat menu baru
        Menu::create([
            'namamenu' => $request->namamenu,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    // Tampilkan form edit menu
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('menu.edit', compact('menu'));
    }

    // Update menu
    public function update(Request $request, $id)
    {
        // Validasi input sesuai kolom database
        $request->validate([
            'namamenu' => 'required|string|max:100',
            'harga' => 'required|numeric',
            'kategori' => 'required|string|max:50',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $menu = Menu::findOrFail($id);

        // Handle upload foto jika ada
        $fotoPath = $menu->foto;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('menu', 'public');
        }

        // Update menu
        $menu->update([
            'namamenu' => $request->namamenu,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui!');
    }

    // Hapus menu
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus!');
    }
}
