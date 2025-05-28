<?php

declare(strict_types=1);

namespace Tests\Feature\Movie;

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

        $movies = $this->movieRepository->paginate(1, 20);

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

    public function test_get_movies_count(): void
    {
        Movie::query()->delete();

        Movie::factory(10)->create();

        $this->assertSame($this->movieRepository->getCount(), 10);
    }

    public function test_storing_a_movie_successful(): void 
    {
        $movie = Movie::factory()->make();

        $data = $this->movieRepository->store([
            'title' => $movie->title,
            'description' => $movie->description,
            'video_id' => $movie->video->id,
            'image' => $movie->image,
        ]);

        $this->assertDatabaseHas('movies', [
            'title' => $movie->title,
            'description' => $movie->description,
            'video_id' => $movie->video->id,
            'image' => $movie->image,
        ]);

        $this->assertIsArray($data);
        $this->assertEquals($data['title'], $movie->title);
        $this->assertEquals($data['description'], $movie->description);
        $this->assertEquals($data['image'], $movie->image);
        $this->assertEquals($data['video_id'], $movie->video->id);
    }
}
