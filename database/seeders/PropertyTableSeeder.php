<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertyTableSeeder extends Seeder
{
    public function run(): void
    {
        Property::factory()->count(5)->create();

        // foreach(Property::all() as $property) {
        //     $users = User::inRandomOrder()->take(rand(1, 5))->pluck('id');
        //     $property->users()->attach($users);
        // }
    }
}
