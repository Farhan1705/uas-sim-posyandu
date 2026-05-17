<?php

namespace Database\Seeders;

use App\Models\PregnantWoman;
use Illuminate\Database\Seeder;

class PregnantWomanSeeder extends Seeder
{
    public function run(): void
    {
        PregnantWoman::create([
            'name' => 'Siti Aminah',
            'husband_name' => 'Bambang Supriadi',
            'due_date' => '2025-08-15',
            'gestational_age' => 24,
            'user_id' => 2,
        ]);

        PregnantWoman::create([
            'name' => 'Dewi Kartika',
            'husband_name' => 'Andi Wijaya',
            'due_date' => '2025-09-20',
            'gestational_age' => 18,
            'user_id' => 3,
        ]);

        PregnantWoman::create([
            'name' => 'Ratna Sari',
            'husband_name' => 'Agus Prasetyo',
            'due_date' => '2025-10-10',
            'gestational_age' => 12,
            'user_id' => 4,
        ]);
    }
}