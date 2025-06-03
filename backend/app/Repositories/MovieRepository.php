<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Movie;
use App\Repositories\Contracts\MovieRepositoryContract;

class MovieRepository implements MovieRepositoryContract
{
    /**
     * @param int $id
     * @return null|array{
     *     id: int,
     *     title: string,
     *     description: string,
     *     image: string,
     *     video_id: int,
     *     video: array{
     *         id: int,
     *         video: string,
     *         created_at: string
     *     },
     *     created_at: string
     * }
     */
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

    /**
     * @param int $page
     * @param int $count
     * @return null|array<int, array{
     *     id: int,
     *     title: string,
     *     description: string,
     *     image: string,
     *     video_id: int,
     *     video: array{
     *         id: int,
     *         video: string,
     *         created_at: string
     *     },
     *     created_at: string
     * }>
     */
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

    /**
     * @return int
     */
    public function getCount(): int
    {
        return Movie::query()->count();
    }

    /**
     * @param array{
     *     title: string,
     *     description: string,
     *     video_id: int,
     *     image: string
     * } $data
     * @return array{
     *     id: int,
     *     title: string,
     *     description: string,
     *     image: string,
     *     video_id: int,
     *     video: array{
     *         id: int,
     *         video: string,
     *         created_at: string
     *     },
     *     created_at: string
     * }
     */
    public function store(array $data): array
    {
        return Movie::query()
            ->create($data)
            ->load('video')
            ->toArray();
    }

    /**
     * @param int $id
     * @param array{
     *     title: string,
     *     description: string,
     *     video_id: int,
     *     image: string
     * } $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $movie = Movie::query()->find($id);

        if (!$movie) {
            return false;
        }

        return $movie->update($data);
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        Movie::query()
            ->where('id', $id)
            ->delete();
    }
}
