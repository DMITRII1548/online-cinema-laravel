<?php

declare(strict_types=1);

use App\Http\Controllers\MovieController;
use App\Http\Controllers\VideoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('movies')->group(function () {
    Route::get('/', [MovieController::class, 'index']);
    Route::get('/{movie:id}', [MovieController::class, 'show']);

    Route::middleware('admin')->group(function () {
        Route::post('/', [MovieController::class, 'store']);
        Route::patch('/{movie:id}', [MovieController::class, 'update']);
        Route::delete('/{movie:id}', [MovieController::class, 'destroy']);
    });
});

Route::apiResource('videos', VideoController::class)
    ->except('update')
    ->middleware('admin');
