<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pesanan;
use App\Models\Menu;
use App\Models\Pelanggan;

class PesananSeeder extends Seeder
{
    public function run(): void
    {
        $menu = Menu::first();
        $pelanggan = Pelanggan::first();

        Pesanan::create([
            'idmenu' => $menu->idmenu,
            'idpelanggan' => $pelanggan->idpelanggan,
            'jumlah' => 2,
            'harga' => $menu->harga * 2,
        ]);
    }
}
