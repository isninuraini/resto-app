<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelanggan;

class PelangganSeeder extends Seeder
{
    public function run(): void
    {
        Pelanggan::insert([
            [
                'namapelanggan' => 'Budi Santoso',
                'jeniskelamin' => 'L',
                'no_telp' => '08123456789',
                'alamat' => 'Jl. Merdeka No. 10',
            ],
            [
                'namapelanggan' => 'Siti Aminah',
                'jeniskelamin' => 'P',
                'no_telp' => '08129876543',
                'alamat' => 'Jl. Sudirman No. 5',
            ],
        ]);
    }
}
