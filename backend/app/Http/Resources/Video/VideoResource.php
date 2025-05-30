<?php

declare(strict_types=1);

namespace App\Http\Resources\Video;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    /**
     * Undocumented function
     *
     * @param Request $request
     * @return array{
     *     id: int,
     *     video: string
     * }
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'video' => $this->resource->getVideoSrc(),
        ];
    }
}
