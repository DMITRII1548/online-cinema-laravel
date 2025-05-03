<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

interface MovieRepositoryContract
{
    public function find(int $id): ?array;

    public function paginate(int $page = 1, int $count = 20): ?array;
}
