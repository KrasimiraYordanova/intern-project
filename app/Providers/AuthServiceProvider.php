<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('update-car', function ($user, $car) {
            return $user->id == $car->user_id;
        });

        Gate::define('delete-car', function($user, $car) {
            return $user->id == $car->user_id;
        });

        // Gate::before(function ($user, $ability) {
        //     if($user->role === 'admin' && in_array($ability, ['delete-car'])) {
        //         return true;
        //     }
        // });

        // Gate::after(function ($user, $ability, $result) {
        //     if($user->role === 'admin') {
        //         return true;
        //     }
        // });
    }
}
