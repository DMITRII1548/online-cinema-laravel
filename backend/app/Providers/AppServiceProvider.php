<?php

declare(strict_types=1);

namespace App\Providers;

use App\Actions\Fortify\LoginResponse;
use App\Actions\Fortify\LogoutResponse;
use App\Actions\Fortify\RegisterResponse;
use App\Repositories\Contracts\MovieRepositoryContract;
use App\Repositories\MovieRepository;
use App\Services\MovieService;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

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

        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);
        $this->app->singleton(RegisterResponseContract::class, RegisterResponse::class);
        $this->app->singleton(LogoutResponseContract::class, LogoutResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}
