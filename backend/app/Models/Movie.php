<?php

namespace App\Models;

use App\Models\Traits\HasImageSrcAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Movie extends Model
{
    use HasImageSrcAttribute;

    protected $fillable = [
        'title',
        'description',
        'image',
        'video_id',
    ];

    public function video(): HasOne
    {
        return $this->hasOne(Video::class);
    }
}
