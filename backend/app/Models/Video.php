<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\HasVideoSrcAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Video extends Model
{
    use HasVideoSrcAttribute;

    protected $fillable = [
        'video',
    ];

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
}
