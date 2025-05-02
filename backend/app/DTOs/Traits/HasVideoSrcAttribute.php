<?php

declare(strict_types=1);

namespace App\DTOs\Traits;

trait HasVideoSrcAttribute
{
    public function getVideoSrc(): string
    {
        return url('').'/storage/'.$this->video;
    }
}
