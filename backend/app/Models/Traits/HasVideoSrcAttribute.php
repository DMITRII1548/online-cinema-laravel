<?php

declare(strict_types=1);

namespace App\Models\Traits;

trait HasVideoSrcAttribute
{
    public function getVideoSrcAttribute(): string
    {
        return url('').'/storage/'.$this->video;
    }
}
