<?php

namespace App\Services;

use App\DTOs\DTO;
use App\DTOs\Movie\MovieDTO;
use App\DTOs\Video\VideoDTO;
use App\Repositories\Contracts\MovieRepositoryContract;

class MovieService
{
    public function __construct(
        private MovieRepositoryContract $movieRepository
    )
    {   
    }

    public function find(int $id): MovieDTO
    {
        $movie = $this->movieRepository->find($id);

        if ($movie == null) {
            abort(404);
        }

        $movie['video'] = VideoDTO::fromArray($movie['video']);

        return MovieDTO::fromArray($movie);
    }
}
