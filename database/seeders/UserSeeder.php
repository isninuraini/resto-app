<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'namauser' => 'Admin Utama',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'administrator',
        ]);

        User::create([
            'namauser' => 'Kasir Satu',
            'username' => 'kasir',
            'password' => Hash::make('kasir123'),
            'role' => 'kasir',
        ]);

        User::create([
            'namauser' => 'Waiter 1',
            'username' => 'waiter',
            'password' => Hash::make('waiter123'),
            'role' => 'waiter',
        ]);

        User::create([
            'namauser' => 'Owner',
            'username' => 'owner',
            'password' => Hash::make('owner123'),
            'role' => 'owner',
        ]);
    }
}
