<?php

namespace Database\Seeders;

use App\Models\Immunization;
use Illuminate\Database\Seeder;

class ImmunizationSeeder extends Seeder
{
    public function run(): void
    {
        // Imunisasi untuk Ahmad Fauzan (child_id = 1) - LENGKAP
        $immunizations1 = [
            ['child_id' => 1, 'vaccine_name' => 'HB-0', 'age_target' => 0, 'date_given' => '2024-05-10', 'status' => 'done'],
            ['child_id' => 1, 'vaccine_name' => 'BCG', 'age_target' => 1, 'date_given' => '2024-06-10', 'status' => 'done'],
            ['child_id' => 1, 'vaccine_name' => 'DPT 1', 'age_target' => 2, 'date_given' => '2024-07-10', 'status' => 'done'],
            ['child_id' => 1, 'vaccine_name' => 'Polio 1', 'age_target' => 2, 'date_given' => '2024-07-10', 'status' => 'done'],
            ['child_id' => 1, 'vaccine_name' => 'DPT 2', 'age_target' => 3, 'date_given' => '2024-08-10', 'status' => 'done'],
            ['child_id' => 1, 'vaccine_name' => 'Polio 2', 'age_target' => 3, 'date_given' => '2024-08-10', 'status' => 'done'],
            ['child_id' => 1, 'vaccine_name' => 'DPT 3', 'age_target' => 4, 'date_given' => '2024-09-10', 'status' => 'done'],
            ['child_id' => 1, 'vaccine_name' => 'Polio 3', 'age_target' => 4, 'date_given' => '2024-09-10', 'status' => 'done'],
            ['child_id' => 1, 'vaccine_name' => 'Campak', 'age_target' => 9, 'date_given' => '2025-02-10', 'status' => 'done'],
        ];

        // Imunisasi untuk Naura Kirana (child_id = 2) - MASIH BERJALAN
        $immunizations2 = [
            ['child_id' => 2, 'vaccine_name' => 'HB-0', 'age_target' => 0, 'date_given' => '2025-01-20', 'status' => 'done'],
            ['child_id' => 2, 'vaccine_name' => 'BCG', 'age_target' => 1, 'date_given' => '2025-02-20', 'status' => 'done'],
            ['child_id' => 2, 'vaccine_name' => 'DPT 1', 'age_target' => 2, 'date_given' => null, 'status' => 'pending'],
            ['child_id' => 2, 'vaccine_name' => 'Polio 1', 'age_target' => 2, 'date_given' => null, 'status' => 'pending'],
        ];

        // Imunisasi untuk Rizki Pratama (child_id = 3) - TIDAK LENGKAP
        $immunizations3 = [
            ['child_id' => 3, 'vaccine_name' => 'HB-0', 'age_target' => 0, 'date_given' => '2024-11-03', 'status' => 'done'],
            ['child_id' => 3, 'vaccine_name' => 'BCG', 'age_target' => 1, 'date_given' => null, 'status' => 'missed'],
            ['child_id' => 3, 'vaccine_name' => 'DPT 1', 'age_target' => 2, 'date_given' => null, 'status' => 'pending'],
        ];

        // Imunisasi untuk Zahra Aulia (child_id = 4) - LENGKAP
        $immunizations4 = [
            ['child_id' => 4, 'vaccine_name' => 'HB-0', 'age_target' => 0, 'date_given' => '2024-12-15', 'status' => 'done'],
            ['child_id' => 4, 'vaccine_name' => 'BCG', 'age_target' => 1, 'date_given' => '2025-01-15', 'status' => 'done'],
            ['child_id' => 4, 'vaccine_name' => 'DPT 1', 'age_target' => 2, 'date_given' => '2025-02-15', 'status' => 'done'],
            ['child_id' => 4, 'vaccine_name' => 'Polio 1', 'age_target' => 2, 'date_given' => '2025-02-15', 'status' => 'done'],
            ['child_id' => 4, 'vaccine_name' => 'DPT 2', 'age_target' => 3, 'date_given' => '2025-03-15', 'status' => 'done'],
            ['child_id' => 4, 'vaccine_name' => 'Polio 2', 'age_target' => 3, 'date_given' => '2025-03-15', 'status' => 'done'],
            ['child_id' => 4, 'vaccine_name' => 'DPT 3', 'age_target' => 4, 'date_given' => '2025-04-15', 'status' => 'done'],
            ['child_id' => 4, 'vaccine_name' => 'Polio 3', 'age_target' => 4, 'date_given' => '2025-04-15', 'status' => 'done'],
        ];

        // Imunisasi untuk Muhammad Rizky (child_id = 5) - LENGKAP
        $immunizations5 = [
            ['child_id' => 5, 'vaccine_name' => 'HB-0', 'age_target' => 0, 'date_given' => '2024-08-22', 'status' => 'done'],
            ['child_id' => 5, 'vaccine_name' => 'BCG', 'age_target' => 1, 'date_given' => '2024-09-22', 'status' => 'done'],
            ['child_id' => 5, 'vaccine_name' => 'DPT 1', 'age_target' => 2, 'date_given' => '2024-10-22', 'status' => 'done'],
            ['child_id' => 5, 'vaccine_name' => 'Polio 1', 'age_target' => 2, 'date_given' => '2024-10-22', 'status' => 'done'],
            ['child_id' => 5, 'vaccine_name' => 'DPT 2', 'age_target' => 3, 'date_given' => '2024-11-22', 'status' => 'done'],
            ['child_id' => 5, 'vaccine_name' => 'Polio 2', 'age_target' => 3, 'date_given' => '2024-11-22', 'status' => 'done'],
            ['child_id' => 5, 'vaccine_name' => 'DPT 3', 'age_target' => 4, 'date_given' => '2024-12-22', 'status' => 'done'],
            ['child_id' => 5, 'vaccine_name' => 'Polio 3', 'age_target' => 4, 'date_given' => '2024-12-22', 'status' => 'done'],
            ['child_id' => 5, 'vaccine_name' => 'Campak', 'age_target' => 9, 'date_given' => '2025-05-22', 'status' => 'pending'],
        ];

        // Insert semua data
        foreach ($immunizations1 as $i) { Immunization::create($i); }
        foreach ($immunizations2 as $i) { Immunization::create($i); }
        foreach ($immunizations3 as $i) { Immunization::create($i); }
        foreach ($immunizations4 as $i) { Immunization::create($i); }
        foreach ($immunizations5 as $i) { Immunization::create($i); }
    }
}