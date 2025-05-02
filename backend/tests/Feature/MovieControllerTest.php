<?php

namespace Tests\Feature;

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
}
