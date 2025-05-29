<?php

declare(strict_types=1);

namespace Tests\Feature\Movie;

use App\DTOs\Movie\FormMovieDTO;
use App\DTOs\Movie\MovieDTO;
use App\Models\Movie;
use App\Services\MovieService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

        Storage::fake('public');

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

    public function test_calculate_max_pages(): void
    {
        Movie::query()->delete();

        Movie::factory(21)->create();

        $pages = $this->movieService->calculateMaxPages(20);

        $this->assertSame(2, $pages);
    }

    public function test_storing_a_movie_successfully(): void
    {
        $movie = Movie::factory()->make();
        $movie = FormMovieDTO::fromArray([
            'title' => $movie->title,
            'description' => $movie->description,
            'video_id' => $movie->video_id,
            'image' => UploadedFile::fake()->create('1.webp', 1),
        ]);

        $data = $this->movieService->store($movie);

        $this->assertTrue($data instanceof MovieDTo);
        $this->assertDatabaseHas('movies', [
            'title' => $movie->title,
            'description' => $movie->description,
            'video_id' => $movie->video_id,
        ]);

        Storage::assertExists($data->image);
    }

    public function test_deleting_a_movie_successful(): void
    {
        $movie = Movie::factory()->create();

        $this->movieService->delete($movie->id);

        $this->assertDatabaseMissing('movies', [
            'id' => $movie->id,
        ]);
    }

    public function test_deleting_a_movie_if_not_exists(): void
    {
        Movie::query()->delete();

        try {
            $this->movieService->delete(1);
        } catch (NotFoundHttpException $e) {
            $this->assertEquals($e->getStatusCode(), 404);
        }
    }

    public function test_updating_a_movie_with_an_image_successful(): void
    {
        $movie = Movie::factory()->create();
        $data = Movie::factory()->make()->toArray();

        $data['image'] = UploadedFile::fake()->create('1.webp');

        $formMovieDTO = FormMovieDTO::fromArray($data);

        $response = $this->movieService->update($movie->id, $formMovieDTO);

        $this->assertTrue($response);
        $this->assertDatabaseHas('movies', [
            'id' => $movie->id,
            'title' => $data['title'],
            'description' => $data['description'],
            'video_id' => $data['video_id'],
        ]);

        $this->assertDatabaseMissing('movies', [
            'id' => $movie->id,
            'image' => $movie->image,
        ]);
        Storage::assertMissing($movie->image);

        $movie = $movie->refresh();
        Storage::assertExists($movie->image);
    }

    public function test_updating_a_movie_without_an_image_successful(): void
    {
        $movie = Movie::factory()->create();
        $data = Movie::factory()->make()->toArray();

        unset($data['image']);

        $formMovieDTO = FormMovieDTO::fromArray($data);

        $response = $this->movieService->update($movie->id, $formMovieDTO);

        $this->assertTrue($response);
        $this->assertDatabaseHas('movies', [
            'id' => $movie->id,
            'title' => $data['title'],
            'description' => $data['description'],
            'video_id' => $data['video_id'],
        ]);
    }

    public function test_updating_a_movie_if_not_exist(): void
    {
        Movie::query()->delete();
        $data = Movie::factory()->make()->toArray();
        $data['image'] = null;

        $formMovieDTO = FormMovieDTO::fromArray($data);

        try {
            $this->movieService->update(1, $formMovieDTO);
        } catch (NotFoundHttpException $e) {
            $this->assertEquals($e->getStatusCode(), 404);
        }
    }
}
