<?php

namespace App\Http\Resources\Movie;

use App\Http\Resources\Video\VideoResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->getImageSrc(),
            'video' => VideoResource::make($this->video)->resolve(),
        ];
    }
}
