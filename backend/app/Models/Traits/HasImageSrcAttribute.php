<?php

declare(strict_types=1);

namespace App\Models\Traits;

trait HasImageSrcAttribute
{
    public function getImageSrcAttribute(): string
    {
        return url('').'/storage/'.$this->image;
    }
}
