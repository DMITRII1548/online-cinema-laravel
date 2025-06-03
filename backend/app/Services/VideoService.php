<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Video\FormVideoDTO;
use App\DTOs\Video\VideoDTO;
use App\Http\Resources\Video\VideoResource;
use App\Repositories\Contracts\VideoRepositoryContract;
use Illuminate\Support\Collection;
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

    /**
     * @param FormVideoDTO $dto
     * @return array{
     *     done: int,
     *     status: bool
     * }|VideoResource
     */
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

    public function find(int $id): VideoDTO
    {
        $video = $this->videoRepository->find($id);

        if ($video) {
            return VideoDTO::fromArray($video);
        }

        abort(404);
    }

    public function destroy(int $id): void
    {
        $videoDTO = $this->find($id);

        Storage::delete($videoDTO->video);
        $this->videoRepository->delete($id);
    }

    /**
     * @param integer $page
     * @param integer $count
     * @return Collection<int, VideoDTO>
     */
    public function paginate(int $page = 1, int $count = 20): Collection
    {
        $videos = $this->videoRepository->paginate($page, $count);

        return collect($videos)
            ->map(fn (array $video) => VideoDTO::fromArray($video));
    }

    public function calculateMaxPages(int $count): int
    {
        return (int)ceil($this->videoRepository->getCount() / $count);
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
