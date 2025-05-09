<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

interface VideoRepositoryContract
{
    public function store(array $data): array;
}
