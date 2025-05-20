<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Video\FormVideoDTO;
use App\DTOs\Video\VideoDTO;
use App\Http\Resources\Video\VideoResource;
use App\Repositories\Contracts\VideoRepositoryContract;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Save\AbstractSave;

class VideoService
{
    public function __construct(
        private VideoRepositoryContract $videoRepository,
    ) {
    }

    public function store(FormVideoDTO $dto): array|VideoResource
    {
        $request = request();
        $request->files->set('file', $dto->video);

        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if (!$receiver->isUploaded()) {
            abort(500);
        }

        $fileReceived = $receiver->receive();

        if ($fileReceived->isFinished()) {
            return $this->handleVideoFinishedReceived($fileReceived);
        }

        $handler = $fileReceived->handler();

        return [
            'done' => $handler->getPercentageDone(),
            'status' => true,
        ];
    }

    public function destroy(int $id): void
    {
        $video = $this->videoRepository->find($id);

        if ($video) {
            $videoDTO = VideoDTO::fromArray($video);
            Storage::delete($videoDTO->video);
            $this->videoRepository->delete($id);
        } else {
            abort(404);
        }
    }

    private function handleVideoFinishedReceived(AbstractSave $fileReceived): VideoResource
    {
        $file = $fileReceived->getFile();
        $extension = $file->getClientOriginalExtension();
        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $uniqueFileName = $fileName . '-' . now()->timestamp . '.' . $extension;

        $path = Storage::putFileAs('videos', $file, $uniqueFileName);

        unlink($file->getPathname());

        $video = $this->videoRepository->store([
            'video' => $path,
        ]);

        return VideoResource::make(VideoDTO::fromArray($video));
    }
}
