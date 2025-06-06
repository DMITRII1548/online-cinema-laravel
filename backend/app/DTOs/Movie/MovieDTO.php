<?php

declare(strict_types=1);

namespace App\DTOs\Movie;

use App\DTOs\DTO;
use App\DTOs\Traits\HasImageSrcAttribute;
use App\DTOs\Video\VideoDTO;

/**
 * @method array{
 *     id: int,
 *     title: string,
 *     description: string,
 *     video: VideoDTO,
 *     image: string
 * } toArray()
 */
final class MovieDTO extends DTO
{
    use HasImageSrcAttribute;

    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $description,
        public readonly VideoDTO $video,
        public readonly string $image,
    ) {
    }
}
