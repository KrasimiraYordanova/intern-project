<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Car::create([
            'brand' => 'Hundai',
            'model' => 'Venue',
            'year' => 2023,
            'price' => 84559.00
        ]);
    }
}
