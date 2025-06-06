<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

interface VideoRepositoryContract
{
    /**
     * @return array{
     *     id: int,
     *     video: string,
     *     created_at: string,
     * }|null
     */
    public function find(int $id): ?array;

    /**
     * @param array{video: string} $data
     * @return array{
     *     id: int,
     *     video: string,
     *     created_at: string,
     * }
     */
    public function store(array $data): array;

    public function delete(int $id): void;

    /**
     * @return array<int, array{
     *     id: int,
     *     video: string,
     *     created_at: string,
     * }>|null
     */
    public function paginate(int $page = 1, int $count = 20): ?array;

    public function getCount(): int;
}
