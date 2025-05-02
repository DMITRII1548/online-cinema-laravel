<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Contracts\MovieRepositoryContract;
use App\Repositories\MovieRepository;
use App\Services\MovieService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Repositories
        $this->app->bind(MovieRepositoryContract::class, fn () => new MovieRepository());

        // Serives
        $this->app->bind(MovieService::class, fn ($app) => new MovieService(
            $app->make(MovieRepositoryContract::class)
        ));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
