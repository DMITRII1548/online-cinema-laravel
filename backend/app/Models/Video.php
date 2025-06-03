<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Video extends Model
{
    /** @use HasFactory<\Database\Factories\VideoFactory> */
    use HasFactory;

    protected $fillable = [
        'video',
    ];

    /**
     * @return HasOne<Movie, $this>
     */
    public function movie(): HasOne
    {
        return $this->hasOne(Movie::class);
    }
}
