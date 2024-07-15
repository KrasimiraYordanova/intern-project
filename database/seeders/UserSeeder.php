<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'krasy',
            'email' => 'krasy_nova@yahoo.com',
            'password' => '12345678',
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'chloe',
            'email' => 'chloe@gmail.com',
            'password' => '12345678',
            'role' => 'user',
        ]);
    }
}
