<?php

namespace App\Providers;

use App\Contract\CarAttachRepositoryInterface;
use App\Contract\PropertyAttachRepositoryInterface;
use App\Contract\CarRepositoryInterface;
use App\Contract\PropertyRepositoryInterface;
use App\Contract\UserRepositoryInterface;
use App\Repositories\CarAttachRepository;
use App\Repositories\PropertyAttachRepository;
use App\Repositories\CarRepository;
use App\Repositories\PropertyRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CarRepositoryInterface::class, CarRepository::class);
        $this->app->bind(PropertyRepositoryInterface::class, PropertyRepository::class);
        $this->app->bind(CarAttachRepositoryInterface::class, CarAttachRepository::class);
        $this->app->bind(PropertyAttachRepositoryInterface::class, PropertyAttachRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
