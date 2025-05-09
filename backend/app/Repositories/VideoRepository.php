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
}
