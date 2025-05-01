<?php

namespace App\Models\Traits;

trait HasImageSrcAttribute
{
    public function getImageSrcAttribute(): string
    {
        return url('').'/storage/'.$this->image;
    }
}
