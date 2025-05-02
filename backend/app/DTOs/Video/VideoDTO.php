<?php

declare(strict_types=1);

namespace App\DTOs\Video;

use App\DTOs\DTO;
use App\DTOs\Traits\HasVideoSrcAttribute;

final class VideoDTO extends DTO
{
    use HasVideoSrcAttribute;

    public function __construct(
        public readonly int $id,
        public readonly string $video,
    ) {
    }
}
