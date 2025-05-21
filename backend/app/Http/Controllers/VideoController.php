<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Video\StoreRequest;
use App\Http\Resources\Video\VideoResource;
use App\Services\VideoService;
use Illuminate\Http\JsonResponse;

class VideoController extends Controller
{
    public function __construct(
        private VideoService $videoService
    ) {
    }

    public function index()
    {

    }

    public function show(int $id)
    {
        $video = $this->videoService->find($id);

        return VideoResource::make($video)->resolve();
    }

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
