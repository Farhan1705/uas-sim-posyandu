<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('mother_id')->constrained('pregnant_women')->onDelete('cascade');
            $table->date('birth_date');
            $table->enum('gender', ['L', 'P']);
            $table->enum('nutrition_status', ['normal', 'waspada', 'kurang'])->default('normal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('children');
    }
};