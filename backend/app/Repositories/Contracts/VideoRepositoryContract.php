<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

interface VideoRepositoryContract
{
    public function find(int $id): ?array;
    public function store(array $data): array;
    public function delete(int $id): void;
    public function paginate(int $page = 1, int $count = 20): ?array;
    public function getCount(): int;
}
