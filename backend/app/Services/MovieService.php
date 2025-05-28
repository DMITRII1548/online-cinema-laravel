<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Movie\FormMovieDTO;
use App\DTOs\Movie\MovieDTO;
use App\Repositories\Contracts\MovieRepositoryContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

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

    public function calculateMaxPages(int $count): int
    {
        return (int)ceil($this->movieRepository->getCount() / $count);
    }

    public function store(FormMovieDTO $movieDTO): MovieDTO
    {
        $path = Storage::put('images', $movieDTO->image);

        $data = $movieDTO->toArray();
        $data['image'] = $path;

        return MovieDTO::fromArray($this->movieRepository->store($data));
    }
}
