<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Movie\IndexRequest;
use App\Http\Resources\Movie\MovieResource;
use App\Services\MovieService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MovieController extends Controller
{
    public function __construct(
        private MovieService $movieService,
    ) {
    }

    public function index(IndexRequest $request): AnonymousResourceCollection
    {
        $page = $request->validated()['page'];

        $movies = $this->movieService->paginate($page, 20);
        $maxPages = $this->movieService->calculateMaxPages(20);

        return MovieResource::collection($movies)
            ->additional([
                'current_page' => $page,
                'last_page' => $maxPages,
            ]);
    }

    public function show(int $id): array
    {
        $movie = $this->movieService->find($id);

        return MovieResource::make($movie)->resolve();
    }
}
