<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE measurements MODIFY COLUMN color_zone ENUM('hijau', 'kuning', 'merah', 'biru') NOT NULL DEFAULT 'hijau'");
        DB::statement("ALTER TABLE children MODIFY COLUMN nutrition_status ENUM('normal', 'waspada', 'kurang', 'obesitas') NOT NULL DEFAULT 'normal'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE measurements MODIFY COLUMN color_zone ENUM('hijau', 'kuning', 'merah') NOT NULL DEFAULT 'hijau'");
        DB::statement("ALTER TABLE children MODIFY COLUMN nutrition_status ENUM('normal', 'waspada', 'kurang') NOT NULL DEFAULT 'normal'");
    }
};
