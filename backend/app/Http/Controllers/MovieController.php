<?php

namespace App\Http\Controllers;

use App\Http\Resources\Movie\MovieResource;
use App\Services\MovieService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function __construct(
        private MovieService $movieService
    )
    {
    }

    public function show(int $id): array
    {
        $movie = $this->movieService->find($id);
        
        return MovieResource::make($movie)->resolve();
    }
}
