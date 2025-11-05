<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaksi;
use App\Models\Pesanan;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        $pesanan = Pesanan::first();

        Transaksi::create([
            'idpesanan' => $pesanan->idpesanan,
            'tgl' => now(),
            'total' => $pesanan->harga,
            'bayar' => 60000,
        ]);
    }
}
