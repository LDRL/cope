<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Contracts\PersonaRepositoryInterface;
use App\Repositories\PersonaRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //Para poder ser uso de la interface
        $this->app->bind(
        PersonaRepositoryInterface::class,
        PersonaRepository::class
    );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
