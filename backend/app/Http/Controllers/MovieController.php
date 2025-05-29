<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Movie\IndexRequest;
use App\Http\Requests\Movie\StoreRequest;
use App\Http\Requests\Movie\UpdateRequest;
use App\Http\Resources\Movie\MovieResource;
use App\Services\MovieService;
use Illuminate\Http\JsonResponse;
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

    public function store(StoreRequest $request): JsonResponse
    {
        $formMovieDTO = $request->toDTO();

        $movie = $this->movieService->store($formMovieDTO);

        return MovieResource::make($movie)
            ->response()
            ->setStatusCode(201);
    }

    public function update(int $id, UpdateRequest $request): JsonResponse
    {
        $formMovieDTO = $request->toDTO();

        $isUpdated = $this->movieService->update($id, $formMovieDTO);

        return response()->json([
            'updated' => $isUpdated,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->movieService->delete($id);

        return response()->json([
            'message' => 'Deleted movie successful',
        ]);
    }
}
