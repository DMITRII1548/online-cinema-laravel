<?php

declare(strict_types=1);

namespace App\DTOs\Movie;

use App\DTOs\DTO;
use Illuminate\Http\UploadedFile;

/**
 * @method array{
 *     title: string,
 *     description: string,
 *     video_id: int,
 *     image: UploadedFile|null
 * } toArray()
 */
final class FormMovieDTO extends DTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly int $video_id,
        public readonly ?UploadedFile $image = null,
    ) {
    }
}
