<?php

namespace App\DTOs\Video;

use App\DTOs\DTO;
use Illuminate\Http\UploadedFile;

final class FormVideoDTO extends DTO
{
    public function __construct(
        public readonly UploadedFile $video,
    )
    {
    }
}