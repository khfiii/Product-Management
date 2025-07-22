<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $data = [
            [
                'nama' => 'TASO 75.65',
                'harga_py' => 93500,
                'harga_k' => 93750,
                'harga_b' => 94250,
                'harga_t' => 94850,
                'harga_e' => 97500,
            ],
            [
                'nama' => 'RENG 32',
                'harga_py' => 48500,
                'harga_k' => 48750,
                'harga_b' => 49000,
                'harga_t' => 49400,
                'harga_e' => 52000,
            ],
            [
                'nama' => 'JAZZ 2X4 (PLATINUM / CRYSTAL)',
                'harga_py' => 33750,
                'harga_k' => 33750,
                'harga_b' => 34000,
                'harga_t' => 34250,
                'harga_e' => 37000,
            ],
            [
                'nama' => 'KCP PLATINUM 2X4',
                'harga_py' => 49750,
                'harga_k' => 49750,
                'harga_b' => 50000,
                'harga_t' => 50250,
                'harga_e' => 53500,
            ],
            [
                'nama' => 'KCP PLATINUM 2X4 TRENDY HITAM',
                'harga_py' => 57500,
                'harga_k' => 57500,
                'harga_b' => 58000,
                'harga_t' => 58500,
                'harga_e' => 60500,
            ],
        ];

        foreach ($data as $item) {
            Barang::create($item);
        }
    }
}
