<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Video;
use App\Repositories\Contracts\VideoRepositoryContract;

class VideoRepository implements VideoRepositoryContract
{
    public function store(array $data): array
    {
        return Video::query()
            ->create($data)
            ->toArray();
    }

    public function find(int $id): ?array
    {
        $video = Video::query()
            ->find($id);

        if (!$video) {
            return null;
        }

        return $video->toArray();
    }

    public function delete(int $id): void
    {
        Video::query()
            ->where('id', $id)
            ->delete();
    }

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
