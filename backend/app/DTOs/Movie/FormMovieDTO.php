<?php

namespace App\DTOs\Movie;

use App\DTOs\DTO;
use Illuminate\Http\UploadedFile;

final class FormMovieDTO extends DTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly int $video_id,
        public readonly ?UploadedFile $image = null,
    ) 
    {
    }
}
