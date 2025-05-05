<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Movie\MovieDTO;
use App\DTOs\Video\VideoDTO;
use App\Repositories\Contracts\MovieRepositoryContract;
use Illuminate\Support\Collection;

class MovieService
{
    public function __construct(
        private MovieRepositoryContract $movieRepository
    ) {
    }

    public function find(int $id): MovieDTO
    {
        $movie = $this->movieRepository->find($id);

        if (!$movie) {
            abort(404);
        }

        return MovieDTO::fromArray($movie);
    }

    public function paginate(int $page = 1, int $count = 20): Collection
    {
        $movies = $this->movieRepository->paginate($page, $count);

        return collect($movies)
            ->map(fn (array $movie) => MovieDTO::fromArray($movie));
    }
}
