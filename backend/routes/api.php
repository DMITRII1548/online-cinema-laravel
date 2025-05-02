<?php

declare(strict_types=1);

use App\Http\Controllers\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('movies')->group(function () {
    Route::get('/{movie:id}', [MovieController::class, 'show']);
});
