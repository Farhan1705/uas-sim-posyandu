<?php

namespace Database\Seeders;

use App\Models\Measurement;
use Illuminate\Database\Seeder;

class MeasurementSeeder extends Seeder
{
    public function run(): void
    {
        // Pengukuran untuk Ahmad Fauzan (child_id = 1) - NORMAL
        $measurements1 = [
            ['child_id' => 1, 'measurement_date' => '2024-06-10', 'weight' => 5.20, 'height' => 60.00, 'head_circumference' => 38.00, 'color_zone' => 'hijau'],
            ['child_id' => 1, 'measurement_date' => '2024-07-10', 'weight' => 6.00, 'height' => 63.00, 'head_circumference' => 39.50, 'color_zone' => 'hijau'],
            ['child_id' => 1, 'measurement_date' => '2024-08-10', 'weight' => 6.80, 'height' => 66.00, 'head_circumference' => 41.00, 'color_zone' => 'hijau'],
            ['child_id' => 1, 'measurement_date' => '2024-09-10', 'weight' => 7.50, 'height' => 68.00, 'head_circumference' => 42.00, 'color_zone' => 'hijau'],
            ['child_id' => 1, 'measurement_date' => '2024-10-10', 'weight' => 8.00, 'height' => 70.00, 'head_circumference' => 43.00, 'color_zone' => 'hijau'],
            ['child_id' => 1, 'measurement_date' => '2024-11-10', 'weight' => 8.30, 'height' => 72.00, 'head_circumference' => 44.00, 'color_zone' => 'hijau'],
            ['child_id' => 1, 'measurement_date' => '2024-12-10', 'weight' => 8.50, 'height' => 74.00, 'head_circumference' => 45.00, 'color_zone' => 'hijau'],
            ['child_id' => 1, 'measurement_date' => '2025-01-10', 'weight' => 8.80, 'height' => 75.50, 'head_circumference' => 45.50, 'color_zone' => 'hijau'],
            ['child_id' => 1, 'measurement_date' => '2025-02-10', 'weight' => 9.00, 'height' => 77.00, 'head_circumference' => 46.00, 'color_zone' => 'hijau'],
            ['child_id' => 1, 'measurement_date' => '2025-03-10', 'weight' => 9.20, 'height' => 78.00, 'head_circumference' => 46.50, 'color_zone' => 'hijau'],
            ['child_id' => 1, 'measurement_date' => '2025-04-10', 'weight' => 9.50, 'height' => 79.50, 'head_circumference' => 47.00, 'color_zone' => 'hijau'],
        ];

        // Pengukuran untuk Naura Kirana (child_id = 2) - WASPADA
        $measurements2 = [
            ['child_id' => 2, 'measurement_date' => '2025-02-20', 'weight' => 3.20, 'height' => 48.00, 'head_circumference' => 34.00, 'color_zone' => 'kuning'],
            ['child_id' => 2, 'measurement_date' => '2025-03-20', 'weight' => 3.80, 'height' => 51.00, 'head_circumference' => 35.50, 'color_zone' => 'kuning'],
            ['child_id' => 2, 'measurement_date' => '2025-04-20', 'weight' => 4.20, 'height' => 53.00, 'head_circumference' => 36.50, 'color_zone' => 'kuning'],
            ['child_id' => 2, 'measurement_date' => '2025-05-01', 'weight' => 4.50, 'height' => 54.50, 'head_circumference' => 37.00, 'color_zone' => 'kuning'],
        ];

        // Pengukuran untuk Rizki Pratama (child_id = 3) - KURANG
        $measurements3 = [
            ['child_id' => 3, 'measurement_date' => '2024-12-10', 'weight' => 4.50, 'height' => 55.00, 'head_circumference' => 37.00, 'color_zone' => 'merah'],
            ['child_id' => 3, 'measurement_date' => '2025-01-10', 'weight' => 4.80, 'height' => 57.00, 'head_circumference' => 37.50, 'color_zone' => 'merah'],
            ['child_id' => 3, 'measurement_date' => '2025-02-10', 'weight' => 5.00, 'height' => 58.50, 'head_circumference' => 38.00, 'color_zone' => 'merah'],
            ['child_id' => 3, 'measurement_date' => '2025-03-10', 'weight' => 5.20, 'height' => 60.00, 'head_circumference' => 38.50, 'color_zone' => 'merah'],
            ['child_id' => 3, 'measurement_date' => '2025-04-10', 'weight' => 5.30, 'height' => 61.00, 'head_circumference' => 39.00, 'color_zone' => 'merah'],
            ['child_id' => 3, 'measurement_date' => '2025-05-01', 'weight' => 5.40, 'height' => 61.50, 'head_circumference' => 39.00, 'color_zone' => 'merah'],
        ];

        // Pengukuran untuk Zahra Aulia (child_id = 4) - NORMAL
        $measurements4 = [
            ['child_id' => 4, 'measurement_date' => '2025-01-15', 'weight' => 3.50, 'height' => 49.00, 'head_circumference' => 34.50, 'color_zone' => 'hijau'],
            ['child_id' => 4, 'measurement_date' => '2025-02-15', 'weight' => 4.20, 'height' => 52.00, 'head_circumference' => 36.00, 'color_zone' => 'hijau'],
            ['child_id' => 4, 'measurement_date' => '2025-03-15', 'weight' => 4.90, 'height' => 55.00, 'head_circumference' => 37.50, 'color_zone' => 'hijau'],
            ['child_id' => 4, 'measurement_date' => '2025-04-15', 'weight' => 5.50, 'height' => 57.50, 'head_circumference' => 38.50, 'color_zone' => 'hijau'],
        ];

        // Pengukuran untuk Muhammad Rizky (child_id = 5) - NORMAL
        $measurements5 = [
            ['child_id' => 5, 'measurement_date' => '2024-09-22', 'weight' => 4.50, 'height' => 54.00, 'head_circumference' => 36.50, 'color_zone' => 'hijau'],
            ['child_id' => 5, 'measurement_date' => '2024-10-22', 'weight' => 5.20, 'height' => 57.00, 'head_circumference' => 38.00, 'color_zone' => 'hijau'],
            ['child_id' => 5, 'measurement_date' => '2024-11-22', 'weight' => 5.90, 'height' => 60.00, 'head_circumference' => 39.50, 'color_zone' => 'hijau'],
            ['child_id' => 5, 'measurement_date' => '2024-12-22', 'weight' => 6.50, 'height' => 63.00, 'head_circumference' => 41.00, 'color_zone' => 'hijau'],
            ['child_id' => 5, 'measurement_date' => '2025-01-22', 'weight' => 7.00, 'height' => 65.50, 'head_circumference' => 42.00, 'color_zone' => 'hijau'],
            ['child_id' => 5, 'measurement_date' => '2025-02-22', 'weight' => 7.40, 'height' => 68.00, 'head_circumference' => 43.00, 'color_zone' => 'hijau'],
            ['child_id' => 5, 'measurement_date' => '2025-03-22', 'weight' => 7.80, 'height' => 70.00, 'head_circumference' => 44.00, 'color_zone' => 'hijau'],
            ['child_id' => 5, 'measurement_date' => '2025-04-22', 'weight' => 8.10, 'height' => 72.00, 'head_circumference' => 44.50, 'color_zone' => 'hijau'],
        ];

        // Insert semua data
        foreach ($measurements1 as $m) { Measurement::create($m); }
        foreach ($measurements2 as $m) { Measurement::create($m); }
        foreach ($measurements3 as $m) { Measurement::create($m); }
        foreach ($measurements4 as $m) { Measurement::create($m); }
        foreach ($measurements5 as $m) { Measurement::create($m); }
    }
}