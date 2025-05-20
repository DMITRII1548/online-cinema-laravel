<?php

declare(strict_types=1);

namespace Tests\Feature\Movie;

use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MovieControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_showing_a_movie_if_it_exists(): void
    {
        $movie = Movie::factory()->create()->load('video');

        $response = $this->get("/api/movies/{$movie->id}");

        $response->assertOk()
            ->assertExactJsonStructure([
                'id',
                'title',
                'description',
                'image',
                'video' => [
                    'id',
                    'video',
                ],
            ])
            ->assertJsonPath('id', $movie->id)
            ->assertJsonPath('title', $movie->title)
            ->assertJsonPath('description', $movie->description)
            ->assertJsonPath('image', url('').'/storage/'.$movie->image)
            ->assertJsonPath('video.id', $movie->video->id)
            ->assertJsonPath('video.video', url('').'/storage/'.$movie->video->video);
    }

    public function test_showing_a_movie_if_not_exists(): void
    {
        $movie = Movie::factory()->create()->load('video');
        $movie->id++;

        $response = $this->get("/api/movies/{$movie->id}");

        $response->assertNotFound();
    }

    public function test_paginate_movies_without_page_parameter(): void
    {
        Movie::query()->delete();

        Movie::factory(21)->create();

        $response = $this->get('/api/movies');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
                        'image',
                        'video' => [
                            'id',
                            'video',
                        ],
                    ],
                ],
                'current_page',
                'last_page',
            ])
            ->assertJsonCount(20, 'data')
            ->assertJsonPath('current_page', 1)
            ->assertJsonPath('last_page', 2);
    }

    public function test_paginate_movies_with_page_parameter(): void
    {
        Movie::query()->delete();

        Movie::factory(41)->create();

        $response = $this->get('/api/movies?page=2');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
                        'image',
                        'video' => [
                            'id',
                            'video',
                        ],
                    ],
                ],
                'current_page',
                'last_page',
            ])
            ->assertJsonCount(20, 'data')
            ->assertJsonPath('current_page', 2)
            ->assertJsonPath('last_page', 3);
    }
}
