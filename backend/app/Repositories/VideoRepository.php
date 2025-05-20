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
}
