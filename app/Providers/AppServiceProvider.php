<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Gate untuk role BIDAN
        Gate::define('bidan', function (User $user) {
            return $user->role === 'bidan';
        });

        // Gate untuk role ORANG TUA
        Gate::define('orangTua', function (User $user) {
            return $user->role === 'orang_tua';
        });

        // Gate untuk akses data anak (apakah anak ini milik user yang login)
        Gate::define('aksesAnak', function (User $user, $child) {
            if ($user->role === 'bidan') {
                return true; // Bidan bisa akses semua anak
            }
            // Orang tua hanya bisa akses anaknya sendiri
            $mother = $user->pregnantWoman;
            return $mother && $child->mother_id === $mother->id;
        });

        // Gate untuk akses data ibu hamil
        Gate::define('aksesIbuHamil', function (User $user, $pregnantWoman) {
            if ($user->role === 'bidan') {
                return true; // Bidan bisa akses semua
            }
            // Orang tua hanya bisa akses datanya sendiri
            return $pregnantWoman->user_id === $user->id;
        });
    }
}