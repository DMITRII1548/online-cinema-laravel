<?php

declare(strict_types=1);

namespace App\DTOs\Traits;

trait HasImageSrcAttribute
{
    public function getImageSrc(): string
    {
        return url('').'/storage/'.$this->image;
    }
}
