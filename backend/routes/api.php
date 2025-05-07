<?php

declare(strict_types=1);

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

Route::prefix('movies')->group(function () {
    Route::get('/', [MovieController::class, 'index']);
    Route::get('/{movie:id}', [MovieController::class, 'show']);
});
