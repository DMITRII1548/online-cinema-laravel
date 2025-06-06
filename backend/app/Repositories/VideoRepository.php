<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Video;
use App\Repositories\Contracts\VideoRepositoryContract;

class VideoRepository implements VideoRepositoryContract
{
    /**
     * @param array{video: string} $data
     * @return array{
     *     id: int,
     *     video: string,
     *     created_at: string,
     * }
     */
    public function store(array $data): array
    {
        $video =  Video::query()
            ->create($data);

        return [
            'id' => $video->id,
            'video' => $video->video,
            'created_at' => (string)$video->created_at,
        ];
    }

    /**
     * @return array{
     *     id: int,
     *     video: string,
     *     created_at: string,
     * }|null
     */
    public function find(int $id): ?array
    {
        $video = Video::query()
            ->find($id);

        if (!$video) {
            return null;
        }

        return [
            'id' => $video->id,
            'video' => $video->video,
            'created_at' => (string)$video->created_at,
        ];
    }

    public function delete(int $id): void
    {
        Video::query()
            ->where('id', $id)
            ->delete();
    }

    /**
     * @return array<int, array{
     *     id: int,
     *     video: string,
     *     created_at: string,
     * }>|null
     */
    public function paginate(int $page = 1, int $count = 20): ?array
    {
        $offset = ($page - 1) * $count;

        $videos = Video::query()
            ->offset($offset)
            ->limit($count)
            ->get();

        return $videos->isNotEmpty() ? $videos->toArray() : null;
    }

    public function getCount(): int
    {
        return Video::query()
            ->count();
    }
}
