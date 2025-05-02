<?php

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
            $data = $this->movieService->find($movie->id + 1);
        } catch (NotFoundHttpException $e) {
            $this->assertEquals($e->getStatusCode(), 404);
        }
    }
}
