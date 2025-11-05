<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        Menu::insert([
            ['namamenu' => 'Nasi Goreng Spesial', 'harga' => 25000],
            ['namamenu' => 'Mie Ayam Bakso', 'harga' => 20000],
            ['namamenu' => 'Es Teh Manis', 'harga' => 5000],
            ['namamenu' => 'Ayam Geprek', 'harga' => 22000],
        ]);
    }
}
