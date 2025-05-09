<?php

declare(strict_types=1);

use App\Http\Middleware\HasAdminRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('admin', [
            'auth:sanctum',
            HasAdminRole::class,
        ]);

        $middleware->validateCsrfTokens([
            'api/login',
            'api/register',
            'api/logout'
        ]);

        $middleware->redirectGuestsTo(fn () => abort(401));
        $middleware->redirectUsersTo(fn () => abort(403));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            return $request->expectsJson() || $request->is('api/*');
        });
    })->create();
