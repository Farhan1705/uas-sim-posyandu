<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Gate::define('bidan', function (User $user) {
            return $user->role === 'bidan';
        });

        Gate::define('orangTua', function (User $user) {
            return $user->role === 'orang_tua';
        });

        Gate::define('aksesAnak', function (User $user, $child) {
            if ($user->role === 'bidan') {
                return true;
            }
            $mother = $user->pregnantWoman;
            return $mother && $child->mother_id === $mother->id;
        });

        Gate::define('aksesIbuHamil', function (User $user, $pregnantWoman) {
            if ($user->role === 'bidan') {
                return true;
            }
            return $pregnantWoman->user_id === $user->id;
        });
    }
}