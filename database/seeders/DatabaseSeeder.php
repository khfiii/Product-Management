<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\BarangSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'kahfi',
            'email' => 'kahfi@gmail.com',
            'password' => 'kahfi55555'
        ]);

         $this->call([
            BarangSeeder::class,
            PelangganSeeder::class
        ]);
    }
}
