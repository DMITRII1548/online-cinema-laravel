<?php

namespace App\Repositories\Contracts;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Model;

interface MovieRepositoryContract
{
    public function find(int $id): ?array;
}
