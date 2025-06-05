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

    /**
     * @param int $id
     * @return MovieDTO
     */
    public function find(int $id): MovieDTO
    {
        $movie = $this->movieRepository->find($id);

        if (!$movie) {
            abort(404);
        }

        return MovieDTO::fromArray($movie);
    }

    /**
     * @param int $page
     * @param int $count
     * @return Collection<int, MovieDTO>
     */
    public function paginate(int $page = 1, int $count = 20): Collection
    {
        $movies = $this->movieRepository->paginate($page, $count);

        return collect($movies)
            ->map(fn (array $movie) => MovieDTO::fromArray($movie));
    }

    /**
     * @param int $count
     * @return int
     */
    public function calculateMaxPages(int $count): int
    {
        return (int)ceil($this->movieRepository->getCount() / $count);
    }

    /**
     * @param FormMovieDTO $movieDTO
     * @return MovieDTO
     */
    public function store(FormMovieDTO $movieDTO): MovieDTO
    {
        if (is_null($movieDTO->image)) {
            abort(500);
        }

        $path = (string)Storage::put('images', $movieDTO->image);

        $data = $movieDTO->toArray();
        $data['image'] = $path;

        return MovieDTO::fromArray($this->movieRepository->store($data));
    }


    /**
     * @param int $id
     * @param FormMovieDTO $movieDTO
     * @return bool
     */
    public function update(int $id, FormMovieDTO $movieDTO): bool
    {
        $movie = $this->movieRepository->find($id);

        if (!$movie) {
            abort(404);
        }

        $movie = MovieDTO::fromArray($movie);

        $data = $movieDTO->toArray();

        if ($movieDTO->image) {
            Storage::delete($movie->image);
            $data['image'] = (string)Storage::put('images', $movieDTO->image);
        } else {
            unset($data['image']);
        }

        return $this->movieRepository->update($id, $data);
    }

    /**
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->find($id);

        $this->movieRepository->delete($id);
    }
}
