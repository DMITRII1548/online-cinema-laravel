<?php

declare(strict_types=1);

namespace App\DTOs\Video;

use App\DTOs\DTO;
use Illuminate\Http\UploadedFile;

/**
 * @method array{
 *     video: UploadedFile
 * } toArray()
 */
final class FormVideoDTO extends DTO
{
    public function __construct(
        public readonly UploadedFile $video,
    ) {
    }
}
