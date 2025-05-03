<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Movie;
use App\Repositories\Contracts\MovieRepositoryContract;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MovieRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private MovieRepositoryContract $movieRepository;

    protected function setUp(): void
    {
        $this->withExceptionHandling();

        parent::setUp();

        $this->movieRepository = app()->make(MovieRepositoryContract::class);
    }

    public function test_find_a_movie_if_it_exists(): void
    {
        $movie = Movie::factory()->create();
        $movie = $movie->load('video');

        $data = $this->movieRepository->find($movie->id);

        $this->assertEquals($data, $movie->toArray());
    }

    public function test_find_a_movie_if_it_not_exists(): void
    {
        $movie = Movie::factory()->create();

        $data = $this->movieRepository->find($movie->id + 1);

        $this->assertNull($data);
    }

    public function test_paginate_movies_if_exists(): void
    {
        Movie::factory(100)->create();

        $movies = $this->movieRepository->paginate();

        $this->assertCount(20, $movies);

        $this->assertArrayHasKey('id', $movies[0]);
        $this->assertArrayHasKey('title', $movies[0]);
        $this->assertArrayHasKey('description', $movies[0]);
        $this->assertArrayHasKey('image', $movies[0]);
        $this->assertArrayHasKey('video', $movies[0]);
    
        $this->assertIsArray($movies[0]['video']); 
        $this->assertArrayHasKey('id', $movies[0]['video']);
        $this->assertArrayHasKey('video', $movies[0]['video']);
    }

    public function test_paginate_movies_if_not_exists(): void 
    {
        Movie::query()->delete();

        $movies = $this->movieRepository->paginate();

        $this->assertNull($movies);
    }
}
