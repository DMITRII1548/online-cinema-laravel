<?php

namespace App\Repositories\Contracts;

interface VideoRepositoryContract
{
    public function store(array $data): array;
}
