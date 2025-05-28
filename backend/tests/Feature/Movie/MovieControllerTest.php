<?php

declare(strict_types=1);

namespace Tests\Feature\Movie;

use App\Models\Movie;
use App\Models\Role;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MovieControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $role = Role::firstOrCreate(['name' => 'admin']);
        $this->user = User::factory()->create();
        $this->user->roles()->sync($role);

        $this->withExceptionHandling();
    }

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

    public function test_storing_a_movie_successful(): void
    {
        $this->actingAs($this->user);

        $video = Video::factory()->create();
        $file = UploadedFile::fake()->create('1.webp', 1);

        $response = $this->post('/api/movies/', [
            'title' => fake()->word(),
            'description' => fake()->text(),
            'image' => $file,
            'video_id' => $video->id,
        ]);

        $response->assertCreated()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'description',
                    'image',
                    'video' => [
                        'id',
                        'video',
                    ],
                ],
            ]);
        
    }
}
