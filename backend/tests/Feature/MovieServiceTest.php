<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\DTOs\Movie\MovieDTO;
use App\Models\Movie;
use App\Services\MovieService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class MovieServiceTest extends TestCase
{
    use RefreshDatabase;

    private MovieService $movieService;

    protected function setUp(): void
    {
        $this->withExceptionHandling();

        parent::setUp();

        $this->movieService = app()->make(MovieService::class);
    }

    public function test_find_a_movie_if_exists(): void
    {
        $movie = Movie::factory()->create();
        $data = $this->movieService->find($movie->id);

        $this->assertTrue($data instanceof MovieDTO);
    }


    public function test_find_a_movie_if_not_exists(): void
    {
        try {
            $movie = Movie::factory()->create();
            $this->movieService->find($movie->id + 1);
        } catch (NotFoundHttpException $e) {
            $this->assertEquals($e->getStatusCode(), 404);
        }
    }

    public function test_paginate_movies_if_exists(): void
    {
        Movie::factory(100)->create();

        $movies = Movie::query()
            ->offset(0)
            ->limit(20)
            ->with('video')
            ->get()
            ->toArray();

        $movies = collect($movies)
            ->map(fn (array $movie) => MovieDTO::fromArray($movie));

        $data = $this->movieService->paginate(1, 20);

        $this->assertEquals($movies, $data);
    }

    public function test_paginate_movies_if_not_exists(): void
    {
        Movie::query()->delete();

        $data = $this->movieService->paginate(1, 20);

        $this->assertEquals(collect([]), $data);
    }
}
