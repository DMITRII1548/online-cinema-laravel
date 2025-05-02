<?php

namespace App\Repositories;

use App\Models\Movie;
use App\Repositories\Contracts\MovieRepositoryContract;

class MovieRepository implements MovieRepositoryContract
{
    public function find(int $id): ?array
    {
        $movie = Movie::query()
            ->with('video')
            ->find($id);
    
        if (!$movie) {
            return null;
        }
    
        $data = $movie->toArray();
    
        return $data;
    }
}
