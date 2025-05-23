<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'video_id',
    ];

    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }
}
