<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

interface MovieRepositoryContract
{
    public function find(int $id): ?array;
}
