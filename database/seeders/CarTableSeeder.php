<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CarTableSeeder extends Seeder
{
    public function run(): void
    {
        // Car::factory()->count(5)->create();

        foreach(Car::all() as $car) {
            $users = User::inRandomOrder()->take(rand(1, 5))->pluck('id');
            $car->users()->attach($users);
        }
    }
}
