<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Movie\IndexRequest;
use App\Http\Requests\Video\StoreRequest;
use App\Http\Resources\Video\VideoResource;
use App\Services\VideoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class VideoController extends Controller
{
    public function __construct(
        private VideoService $videoService
    ) {
    }

    public function index(IndexRequest $request): AnonymousResourceCollection
    {
        $page = $request->validated()['page'];

        $movies = $this->videoService->paginate($page, 20);
        $maxPages = $this->videoService->calculateMaxPages(20);

        return VideoResource::collection($movies)
            ->additional([
                'current_page' => $page,
                'last_page' => $maxPages,
            ]);
    }

    /**
     * @return array{id: int, video: string}
     */
    public function show(int $id): array
    {
        $video = $this->videoService->find($id);

        return VideoResource::make($video)->resolve();
    }

    /**
     * @return array{
     *     done: int,
     *     status: bool
     * }|VideoResource
     */
    public function store(StoreRequest $request): array|VideoResource
    {
        $videoDTO = $request->toDTO();
        return $this->videoService->store($videoDTO);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->videoService->destroy($id);

        return response()->json([
            'message' => 'Video deleted successfully',
        ]);
    }
}
