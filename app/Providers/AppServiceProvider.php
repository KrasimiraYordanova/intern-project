<?php

namespace App\Providers;

use App\Events\CarCreated;
use App\Listeners\NotifyAdminAboutNewCar;
use Illuminate\Support\ServiceProvider;

use App\Models\Car;
use App\Policies\CarPolicy;
use Illuminate\Support\Facades\Gate;

use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        User::observe(UserObserver::class);
        // Event::listen(
        //     CarCreated::class,
        //     NotifyAdminAboutNewCar::class,
        // );
    }
}
