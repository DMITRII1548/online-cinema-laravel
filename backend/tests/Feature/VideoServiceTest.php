<?php

declare(strict_types=1);

namespace Tests\Feature\Services;

use App\DTOs\Video\FormVideoDTO;
use App\Http\Resources\Video\VideoResource;
use App\Repositories\Contracts\VideoRepositoryContract;
use App\Services\VideoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Pion\Laravel\ChunkUpload\Save\AbstractSave;
use Tests\TestCase;

class VideoServiceTest extends TestCase
{
    use RefreshDatabase;

    private VideoService $service;
    private \Mockery\MockInterface $repoMock;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        Mockery::mock('alias:Pion\\Laravel\\ChunkUpload\\Handler\\HandlerFactory')
            ->shouldReceive('classFromRequest')
            ->andReturn('HandlerClass');

        $this->repoMock = Mockery::mock(VideoRepositoryContract::class);
        $this->app->instance(VideoRepositoryContract::class, $this->repoMock);

        $this->service = $this->app->make(VideoService::class);
    }

    #[\PHPUnit\Framework\Attributes\RunInSeparateProcess]
    #[\PHPUnit\Framework\Attributes\PreserveGlobalState(false)]
    public function test_store_returns_video_resource_on_finished_upload(): void
    {
        $videoFile = UploadedFile::fake()->create('movie.mp4', 1024, 'video/mp4');
        $dto = new FormVideoDTO(video: $videoFile);

        $receiverMock = Mockery::mock('overload:Pion\\Laravel\\ChunkUpload\\Receiver\\FileReceiver');
        $receiverMock->shouldReceive('__construct')
            ->once()
            ->with('file', Mockery::type(\Illuminate\Http\Request::class), 'HandlerClass')
            ->andReturnNull();
        $receiverMock->shouldReceive('isUploaded')->once()->andReturn(true);

        $saveMock = Mockery::mock(AbstractSave::class);
        $receiverMock->shouldReceive('receive')->once()->andReturn($saveMock);
        $saveMock->shouldReceive('isFinished')->once()->andReturn(true);
        $saveMock->shouldReceive('getFile')->once()->andReturn($videoFile);

        $this->repoMock->shouldReceive('store')
            ->once()
            ->with(Mockery::on(fn (array $data) => isset($data['video']) && str_starts_with($data['video'], 'videos/')))
            ->andReturn([
                'id'    => 123,
                'video' => 'videos/movie.mp4',
            ]);

        $resource = $this->service->store($dto);

        $this->assertInstanceOf(VideoResource::class, $resource);
        $resolved = $resource->resolve();
        $this->assertEquals(123, $resolved['id']);
        $this->assertEquals(config('app.url').'/storage/'.'videos/movie.mp4', $resolved['video']);
    }

    #[\PHPUnit\Framework\Attributes\RunInSeparateProcess]
    #[\PHPUnit\Framework\Attributes\PreserveGlobalState(false)]
    public function test_store_returns_progress_on_incomplete_upload(): void
    {
        $chunkFile = UploadedFile::fake()->create('part.mp4', 100, 'video/mp4');
        $dto = new FormVideoDTO(video: $chunkFile);

        $receiverMock = Mockery::mock('overload:Pion\\Laravel\\ChunkUpload\\Receiver\\FileReceiver');
        $receiverMock->shouldReceive('__construct')->andReturnNull();
        $receiverMock->shouldReceive('isUploaded')->once()->andReturn(true);

        $saveMock = Mockery::mock(AbstractSave::class);
        $receiverMock->shouldReceive('receive')->once()->andReturn($saveMock);
        $saveMock->shouldReceive('isFinished')->once()->andReturn(false);

        $handlerMock = Mockery::mock();
        $saveMock->shouldReceive('handler')->once()->andReturn($handlerMock);
        $handlerMock->shouldReceive('getPercentageDone')->once()->andReturn(56.7);

        $this->repoMock->shouldNotReceive('store');

        $response = $this->service->store($dto);

        $this->assertIsArray($response);
        $this->assertEquals(56.7, $response['done']);
        $this->assertTrue($response['status']);
    }
}
