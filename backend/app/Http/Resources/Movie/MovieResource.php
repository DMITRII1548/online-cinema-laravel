<?php

declare(strict_types=1);

namespace App\Http\Resources\Movie;

use App\Http\Resources\Video\VideoResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Undocumented function
     *
     * @param Request $request
     * @return array{
     *     id: int,
     *     title: string,
     *     description: string
     *     image: string,
     *     video: array
     * }
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'description' => $this->resource->description,
            'image' => $this->resource->getImageSrc(),
            'video' => VideoResource::make($this->resource->video)->resolve(),
        ];
    }
}
