<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tingkat;

class TingkatSeeder extends Seeder
{
    public function run(): void
    {
        Tingkat::insert([
            ['nama' => 'VII', 'urutan' => 1],
            ['nama' => 'VIII', 'urutan' => 2],
            ['nama' => 'IX', 'urutan' => 3],
        ]);
    }
}
