<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

interface VideoRepositoryContract
{
    public function find(int $id): ?array;
    public function store(array $data): array;
    public function delete(int $id): void;
}
