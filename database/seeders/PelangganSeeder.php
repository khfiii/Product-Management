<?php

namespace Database\Seeders;

use App\Level;
use App\Models\Pelanggan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $datas = [
            [
                'nama' => 'ZAKIR',
                'level_harga' => Level::PYK,
                'termin' => 30
            ],
            [
                'nama' => 'CASH',
                'level_harga' => Level::ECER,
                'termin' => 0
            ],
            [
                'nama' => 'TIARA',
                'level_harga' => Level::PYK,
                'termin' => 30
            ],
            [
                'nama' => 'BANGUN JAYA',
                'level_harga' => Level::PYK,
                'termin' => 30
            ],
            [
                'nama' => 'ANUGERAH PELAIHARI',
                'level_harga' => Level::BESAR,
                'termin' => 30
            ],
            [
                'nama' => 'SUMBER USAHA 2',
                'level_harga' => Level::PYK,
                'termin' => 30
            ],
        ];

         foreach ($datas as $data) {
                Pelanggan::create($data);
            }
    }
}
