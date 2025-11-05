<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Pesanan;
use App\Models\Menu;
use App\Models\Pelanggan;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['pesanan.menu', 'pesanan.pelanggan'])
            ->orderBy('tgl', 'desc')
            ->get();

        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $pesanans = Pesanan::with(['menu', 'pelanggan'])
            ->whereDoesntHave('transaksi')
            ->get();

        return view('transaksi.create', compact('pesanans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idpesanan' => 'required|array',
            'bayar' => 'required|numeric|min:0',
        ], [
            'idpesanan.required' => 'Pesanan harus dipilih.',
            'bayar.required' => 'Jumlah uang harus diisi.',
        ]);

        // === Hitung total semua pesanan ===
        $totalSemua = 0;
        foreach ($request->idpesanan as $id) {
            $pesanan = Pesanan::findOrFail($id);
            $totalSemua += (int) $pesanan->harga;
        }

        // === Validasi uang bayar cukup ===
        if ($request->bayar < $totalSemua) {
            return back()->withErrors([
                'bayar' => 'Jumlah uang kurang dari total semua pesanan (Rp ' . number_format($totalSemua, 0, ',', '.') . ')'
            ])->withInput();
        }

        // === Hitung kembali ===
        $kembali = $request->bayar - $totalSemua;

        // === Simpan transaksi (satu record untuk satu gabungan pesanan) ===
        // Jika kamu ingin 1 transaksi bisa punya banyak pesanan, gunakan relasi many-to-many
        // atau simpan dalam format json.
        foreach ($request->idpesanan as $id) {
            $pesanan = Pesanan::findOrFail($id);
            Transaksi::create([
                'idpesanan' => $pesanan->idpesanan,
                'tgl' => now(),
                'total' => (int) $pesanan->harga,
                'bayar' => (int) $request->bayar,
                'kembali' => $kembali, // simpan ke DB
            ]);
        }

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil ditambahkan! Kembalian: Rp ' . number_format($kembali, 0, ',', '.'));
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['pesanan.menu', 'pesanan.pelanggan']);
        return view('transaksi.show', compact('transaksi'));
    }

    public function edit(Transaksi $transaksi)
    {
        $transaksi->load(['pesanan.menu', 'pesanan.pelanggan']);
        return view('transaksi.edit', compact('transaksi'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'bayar' => 'required|numeric|min:0',
        ]);

        if ($request->bayar < $transaksi->total) {
            return back()->withErrors(['bayar' => 'Jumlah bayar tidak boleh kurang dari total harga']);
        }

        $kembali = $request->bayar - $transaksi->total;

        $transaksi->update([
            'bayar' => $request->bayar,
            'kembali' => $kembali,
        ]);

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus!');
    }
}
