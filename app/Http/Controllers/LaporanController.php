<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Pesanan;

class LaporanController extends Controller
{
    /**
     * Tampilkan daftar laporan transaksi.
     */
    public function index(Request $request)
    {
        $query = Transaksi::with(['pesanan', 'pesanan.menu', 'pesanan.pelanggan']);

        // Filter berdasarkan tanggal jika ada
        if ($request->has('from') && $request->has('to') && $request->from && $request->to) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        $transaksis = $query->orderBy('created_at', 'desc')->get();

        return view('laporan.index', compact('transaksis'));
    }

    /**
     * Form tambah laporan baru
     */
    public function create()
    {
        // Ambil semua menu untuk dipilih
        $menus = \App\Models\Menu::all();

        return view('laporan.create', compact('menus'));
    }

    /**
     * Simpan laporan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:100',
            'idmenu' => 'required|exists:menu,idmenu',
            'jumlah' => 'required|integer|min:1',
            'total' => 'required|numeric|min:0',
            'bayar' => 'required|numeric|min:0|gte:total',
        ], [
            'nama_pelanggan.required' => 'Nama pelanggan harus diisi.',
            'nama_pelanggan.string' => 'Nama pelanggan harus berupa teks.',
            'nama_pelanggan.max' => 'Nama pelanggan maksimal 100 karakter.',
            'idmenu.required' => 'Menu harus dipilih.',
            'idmenu.exists' => 'Menu yang dipilih tidak valid.',
            'jumlah.required' => 'Jumlah harus diisi.',
            'jumlah.integer' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah minimal 1.',
            'total.required' => 'Total harga harus diisi.',
            'total.numeric' => 'Total harga harus berupa angka.',
            'total.min' => 'Total harga tidak boleh kurang dari 0.',
            'bayar.required' => 'Jumlah bayar harus diisi.',
            'bayar.numeric' => 'Jumlah bayar harus berupa angka.',
            'bayar.min' => 'Jumlah bayar tidak boleh kurang dari 0.',
            'bayar.gte' => 'Jumlah bayar tidak boleh kurang dari total harga.',
        ]);

        // Cari atau buat pelanggan baru
        $pelanggan = \App\Models\Pelanggan::firstOrCreate(
            ['namapelanggan' => $request->nama_pelanggan],
            [
                'jeniskelamin' => 'L', // Default
                'no_telp' => '-',
                'alamat' => '-'
            ]
        );

        // Ambil menu untuk mendapatkan harga
        $menu = \App\Models\Menu::find($request->idmenu);
        $harga = $menu->harga;

        // Buat pesanan baru
        $pesanan = \App\Models\Pesanan::create([
            'idmenu' => $request->idmenu,
            'idpelanggan' => $pelanggan->idpelanggan,
            'jumlah' => $request->jumlah,
            'harga' => $harga,
        ]);

        // Buat transaksi
        Transaksi::create([
            'idpesanan' => $pesanan->idpesanan,
            'total' => $request->total,
            'bayar' => $request->bayar,
            'tgl' => now(),
        ]);

        return redirect()->route('laporan.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    /**
     * Form edit laporan
     */
    public function edit($id)
    {
        $laporan = Transaksi::with(['pesanan'])->findOrFail($id);
        $pesanans = Pesanan::with(['menu', 'pelanggan'])->get();

        return view('laporan.edit', compact('laporan', 'pesanans'));
    }

    /**
     * Simpan hasil edit laporan
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'idpesanan' => 'required|exists:pesanan,idpesanan',
            'total' => 'required|numeric|min:0',
            'bayar' => 'required|numeric|min:0|gte:total',
        ], [
            'idpesanan.required' => 'Pesanan harus dipilih.',
            'idpesanan.exists' => 'Pesanan yang dipilih tidak valid.',
            'total.required' => 'Total harga harus diisi.',
            'total.numeric' => 'Total harga harus berupa angka.',
            'total.min' => 'Total harga tidak boleh kurang dari 0.',
            'bayar.required' => 'Jumlah bayar harus diisi.',
            'bayar.numeric' => 'Jumlah bayar harus berupa angka.',
            'bayar.min' => 'Jumlah bayar tidak boleh kurang dari 0.',
            'bayar.gte' => 'Jumlah bayar tidak boleh kurang dari total harga.',
        ]);

        $laporan = Transaksi::findOrFail($id);
        $laporan->update([
            'idpesanan' => $request->idpesanan,
            'total' => $request->total,
            'bayar' => $request->bayar,
        ]);

        return redirect()->route('laporan.index')->with('success', 'Transaksi berhasil diperbarui!');
    }
}
