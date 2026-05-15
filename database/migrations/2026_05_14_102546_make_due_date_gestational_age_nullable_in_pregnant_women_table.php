<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pregnant_women', function (Blueprint $table) {
            $table->date('due_date')->nullable()->change();
            $table->integer('gestational_age')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('pregnant_women', function (Blueprint $table) {
            $table->date('due_date')->nullable(false)->change();
            $table->integer('gestational_age')->nullable(false)->change();
        });
    }
};
