<?php

namespace App\Http\Controllers;

use App\Http\Requests\Video\StoreRequest;
use App\Http\Resources\Video\VideoResource;
use App\Services\VideoService;

class VideoController extends Controller
{
    public function __construct(
        private VideoService $videoService
    ) {   
    }

    public function index()
    {
        
    }

    public function show()
    {

    }

    public function update()
    {

    }

    public function store(StoreRequest $request): array|VideoResource
    {
        $videoDTO = $request->toDTO(); 
        return $this->videoService->store($videoDTO);       
    }
}
