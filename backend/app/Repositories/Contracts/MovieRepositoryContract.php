<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

interface MovieRepositoryContract
{
    /**
     * @param int $id
     * @return null|array{
     *     id: int,
     *     title: string,
     *     description: string,
     *     image: string,
     *     video_id: int,
     *     video: array{
     *         id: int,
     *         video: string,
     *         created_at: string
     *     },
     *     created_at: string
     * }
     */
    public function find(int $id): ?array;

    /**
     * @param int $page
     * @param int $count
     * @return null|array<int, array{
     *     id: int,
     *     title: string,
     *     description: string,
     *     image: string,
     *     video_id: int,
     *     video: array{
     *         id: int,
     *         video: string,
     *         created_at: string
     *     },
     *     created_at: string
     * }>
     */
    public function paginate(int $page = 1, int $count = 20): ?array;

    
    /**
     * @return int
     */
    public function getCount(): int;

    /**
     * @param array{
     *     title: string,
     *     description: string,
     *     video_id: int,
     *     image: string
     * } $data
     * @return array{
     *     id: int,
     *     title: string,
     *     description: string,
     *     image: string,
     *     video_id: int,
     *     video: array{
     *         id: int,
     *         video: string,
     *         created_at: string
     *     },
     *     created_at: string
     * }
     */
    public function store(array $data): array;

    /**
     * @param int $id
     * @param array{
     *     title: string,
     *     description: string,
     *     video_id: int,
     *     image: string
     * } $data
     * @return bool
     */
    public function update(int $id, array $data): bool;
    
    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;
}
