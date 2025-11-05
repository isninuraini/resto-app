<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Transaksi;
use App\Models\Pesanan;
use App\Models\Pelanggan;
use App\Models\Menu;
use App\Models\Meja;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(401, 'User tidak terautentikasi!');
        }

        // === Data Statistik ===
        $totalTransaksi   = Transaksi::count();
        $totalPesanan     = Pesanan::count();
        $totalPelanggan   = Pelanggan::count();
        $totalPendapatan  = Transaksi::sum('total');
        $totalMenu        = Menu::count();
        $totalMeja        = Meja::count();
        $menuAktif        = Menu::count(); // Jika semua menu dianggap aktif
        $mejaTersedia     = Meja::where('status', 'Tersedia')->count();

        

        $totalLaporan = Transaksi::count();

        // === Transaksi Terbaru ===
        $transaksiTerbaru = Transaksi::with(['pesanan.pelanggan'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // === Data dikirim ke view ===
        $data = compact(
            'user',
            'totalTransaksi',
            'totalPesanan',
            'totalPelanggan',
            'totalPendapatan',
            'totalMenu',
            'totalMeja',
            'menuAktif',
            'mejaTersedia',
            'totalLaporan', 
            'transaksiTerbaru'
        );

        // === Routing berdasarkan Role ===
        switch ($user->role) {
            case 'administrator':
                return view('dashboard.admin', $data);
            case 'waiter':
                return view('dashboard.waiter', $data);
            case 'kasir':
                return view('dashboard.kasir', $data);
            case 'owner':
                return view('dashboard.owner', $data);
            default:
                abort(403, 'Role tidak dikenali: ' . $user->role);
        }
    }
}
