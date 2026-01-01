<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'admin'
        ]);

        // Karyawan
        User::create([
            'name' => 'Karyawan Satu',
            'email' => 'karyawan1@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'karyawan'
        ]);
    }
}
