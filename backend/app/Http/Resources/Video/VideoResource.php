<?php

declare(strict_types=1);

namespace App\Http\Resources\Video;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @method array{id:int, video: string} resolve()
 */
class VideoResource extends JsonResource
{
    /**
     * Undocumented function
     *
     * @return array{
     *     id: int,
     *     video: string
     * }
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (int)$this->resource->id,
            'video' => (string)$this->resource->getVideoSrc(),
        ];
    }
}
