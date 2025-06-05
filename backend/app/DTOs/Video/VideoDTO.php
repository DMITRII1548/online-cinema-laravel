<?php

declare(strict_types=1);

namespace App\DTOs\Video;

use App\DTOs\DTO;
use App\DTOs\Traits\HasVideoSrcAttribute;

/**
 * @method array{
 *     id: int,
 *     video: string
 * } toArray()
 */
final class VideoDTO extends DTO
{
    use HasVideoSrcAttribute;

    public function __construct(
        public readonly int $id,
        public readonly string $video,
    ) {
    }
}
