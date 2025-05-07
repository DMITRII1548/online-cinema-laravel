<?php

declare(strict_types=1);

use App\Http\Controllers\MovieController;
use App\Http\Controllers\VideoController;
use App\Http\Middleware\HasAdminRole;
use Illuminate\Support\Facades\Route;

Route::prefix('movies')->group(function () {
    Route::get('/', [MovieController::class, 'index']);
    Route::get('/{movie:id}', [MovieController::class, 'show']);
});

Route::apiResource('videos', VideoController::class)->middleware(HasAdminRole::class);
