<?php

namespace App\Models\Traits;

trait HasVideoSrcAttribute
{
    public function getVideoSrcAttribute(): string
    {
        return url('').'/storage/'.$this->video;
    }
}
