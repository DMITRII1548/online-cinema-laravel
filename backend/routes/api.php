<?php

declare(strict_types=1);

use App\Http\Controllers\MovieController;
use App\Http\Controllers\VideoController;
use App\Http\Middleware\HasAdminRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('movies')->group(function () {
    Route::get('/', [MovieController::class, 'index']);
    Route::get('/{movie:id}', [MovieController::class, 'show']);
});

Route::apiResource('videos', VideoController::class)->middleware('admin');