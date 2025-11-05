<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Menu;
use App\Models\Pelanggan;
use App\Models\Meja;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    // Tampilkan daftar pesanan
    public function index()
    {
        $pesanans = Pesanan::with(['menu', 'pelanggan', 'meja'])->get();
        return view('pesanan.index', compact('pesanans'));
    }

    // Form tambah pesanan
    public function create()
    {
        $menus = Menu::all();
        $pelanggans = Pelanggan::all();
        $mejas = Meja::where('status', 'tersedia')->get();
        return view('pesanan.create', compact('menus', 'pelanggans', 'mejas'));
    }

    // Simpan pesanan baru (mendukung banyak menu)
    public function store(Request $request)
    {
        $request->validate([
            'idmenu' => 'required|array|min:1',
            'idmenu.*' => 'required|exists:menu,idmenu',
            'idpelanggan' => 'required|exists:pelanggan,idpelanggan',
            'idmeja' => 'required|exists:mejas,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
        ], [
            'idmenu.required' => 'Menu harus dipilih.',
            'idmenu.array' => 'Menu harus dalam bentuk daftar.',
            'idmenu.*.exists' => 'Salah satu menu yang dipilih tidak valid.',
            'idpelanggan.required' => 'Pelanggan harus dipilih.',
            'idpelanggan.exists' => 'Pelanggan yang dipilih tidak valid.',
            'idmeja.required' => 'Meja harus dipilih.',
            'idmeja.exists' => 'Meja yang dipilih tidak valid.',
            'jumlah.required' => 'Jumlah harus diisi.',
            'jumlah.array' => 'Jumlah harus dalam bentuk daftar.',
            'jumlah.*.integer' => 'Jumlah harus berupa angka.',
            'jumlah.*.min' => 'Jumlah minimal 1.',
        ]);

        foreach ($request->idmenu as $menuId) {
            $menu = Menu::findOrFail($menuId);
            $qty = isset($request->jumlah[$menuId]) ? (int) $request->jumlah[$menuId] : 1;
            $harga = $menu->harga * $qty;

            Pesanan::create([
                'idmenu' => $menuId,
                'idpelanggan' => $request->idpelanggan,
                'idmeja' => $request->idmeja,
                'jumlah' => $qty,
                'harga' => $harga,
            ]);
        }

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil ditambahkan!');
    }

    // Form edit pesanan
    public function edit($idpesanan)
    {
        $pesanan = Pesanan::findOrFail($idpesanan);
        $menus = Menu::all();
        $pelanggans = Pelanggan::all();
        $mejas = Meja::where('status', 'tersedia')->orWhere('id', $pesanan->idmeja)->get();
        return view('pesanan.edit', compact('pesanan', 'menus', 'pelanggans', 'mejas'));
    }

    // Update pesanan
    public function update(Request $request, $idpesanan)
    {
        $request->validate([
            'idmenu' => 'required|exists:menu,idmenu',
            'idpelanggan' => 'required|exists:pelanggan,idpelanggan',
            'idmeja' => 'required|exists:mejas,id',
            'jumlah' => 'required|integer|min:1',
        ], [
            'idmenu.required' => 'Menu harus dipilih.',
            'idmenu.exists' => 'Menu yang dipilih tidak valid.',
            'idpelanggan.required' => 'Pelanggan harus dipilih.',
            'idpelanggan.exists' => 'Pelanggan yang dipilih tidak valid.',
            'idmeja.required' => 'Meja harus dipilih.',
            'idmeja.exists' => 'Meja yang dipilih tidak valid.',
            'jumlah.required' => 'Jumlah harus diisi.',
            'jumlah.integer' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah minimal 1.',
        ]);

        $pesanan = Pesanan::findOrFail($idpesanan);
        $menu = Menu::findOrFail($request->idmenu);
        $harga = $menu->harga * $request->jumlah;

        $pesanan->update([
            'idmenu' => $request->idmenu,
            'idpelanggan' => $request->idpelanggan,
            'idmeja' => $request->idmeja,
            'jumlah' => $request->jumlah,
            'harga' => $harga,
        ]);

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil diperbarui!');
    }

    // Hapus pesanan
    public function destroy($idpesanan)
    {
        Pesanan::destroy($idpesanan);
        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dihapus!');
    }
}
