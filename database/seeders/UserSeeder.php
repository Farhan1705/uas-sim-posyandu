<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'dr. Siti Rahma',
            'email' => 'bidan@posyandu.com',
            'password' => Hash::make('password'),
            'role' => 'bidan',
        ]);

        User::create([
            'name' => 'Siti Aminah',
            'email' => 'orangtua@email.com',
            'password' => Hash::make('password'),
            'role' => 'orang_tua',
        ]);

        User::create([
            'name' => 'Dewi Kartika',
            'email' => 'dewi@email.com',
            'password' => Hash::make('password'),
            'role' => 'orang_tua',
        ]);

        User::create([
            'name' => 'Ratna Sari',
            'email' => 'ratna@email.com',
            'password' => Hash::make('password'),
            'role' => 'orang_tua',
        ]);
    }
}