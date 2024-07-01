<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Property::create([
            'type' => 'house',
            'address' => 'California',
            'price' => 234559.00
        ]);
        Property::create([
            'type' => 'villa',
            'address' => 'California',
            'price' => 734559.00
        ]);
        Property::create([
            'type' => 'appartment',
            'address' => 'NewYork',
            'price' => 198559.00
        ]);
        Property::create([
            'type' => 'house',
            'address' => 'Huston',
            'price' => 234559.00
        ]);
        Property::create([
            'type' => 'house',
            'address' => 'Dallas',
            'price' => 234559.00
        ]);
    }
}
