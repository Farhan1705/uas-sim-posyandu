<?php

namespace Database\Seeders;

use App\Models\Child;
use Illuminate\Database\Seeder;

class ChildSeeder extends Seeder
{
    public function run(): void
    {
        Child::create([
            'name' => 'Ahmad Fauzan',
            'mother_id' => 1,
            'birth_date' => '2024-05-10',
            'gender' => 'L',
            'nutrition_status' => 'normal',
        ]);

        Child::create([
            'name' => 'Naura Kirana',
            'mother_id' => 1,
            'birth_date' => '2025-01-20',
            'gender' => 'P',
            'nutrition_status' => 'waspada',
        ]);

        Child::create([
            'name' => 'Rizki Pratama',
            'mother_id' => 2,
            'birth_date' => '2024-11-03',
            'gender' => 'L',
            'nutrition_status' => 'kurang',
        ]);

        Child::create([
            'name' => 'Zahra Aulia',
            'mother_id' => 2,
            'birth_date' => '2024-12-15',
            'gender' => 'P',
            'nutrition_status' => 'normal',
        ]);

        Child::create([
            'name' => 'Muhammad Rizky',
            'mother_id' => 3,
            'birth_date' => '2024-08-22',
            'gender' => 'L',
            'nutrition_status' => 'normal',
        ]);
    }
}