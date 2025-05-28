<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Movie;
use App\Repositories\Contracts\MovieRepositoryContract;

class MovieRepository implements MovieRepositoryContract
{
    public function find(int $id): ?array
    {
        $movie = Movie::query()
            ->with('video')
            ->find($id);

        if (!$movie) {
            return null;
        }

        $data = $movie->toArray();

        return $data;
    }

    public function paginate(int $page = 1, int $count = 20): ?array
    {
        $offset = ($page - 1) * $count;

        $movies = Movie::query()
            ->offset($offset)
            ->limit($count)
            ->with('video')
            ->get();

        return $movies->isNotEmpty() ? $movies->toArray() : null;
    }

    public function getCount(): int
    {
        return Movie::query()->count();
    }

    public function store(array $data): array
    {
        return Movie::query()
            ->create($data)
            ->load('video')
            ->toArray();
    }
}
