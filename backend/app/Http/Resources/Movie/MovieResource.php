<?php

declare(strict_types=1);

namespace App\Http\Resources\Movie;

use App\Http\Resources\Video\VideoResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @method array{
 *     id: int,
 *     title: string,
 *     description: string,
 *     image: string,
 *     video: array{
 *         id: int,
 *         video: string
 *     }
 * } resolve()
 */
class MovieResource extends JsonResource
{
    /**
     * Undocumented function
     *
     * @return array{
     *     id: int,
     *     title: string,
     *     description: string,
     *     image: string,
     *     video: array{
     *         id: int,
     *         video: string
     *     }
     * }
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (int)$this->resource->id,
            'title' => (string)$this->resource->title,
            'description' => (string)$this->resource->description,
            'image' => (string)$this->resource->getImageSrc(),
            'video' => (array)VideoResource::make($this->resource->video)->resolve(),
        ];
    }
}
