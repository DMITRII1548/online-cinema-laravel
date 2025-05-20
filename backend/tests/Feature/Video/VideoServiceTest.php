<?php

namespace Tests\Feature\Video;

use App\Models\Video;
use App\Services\VideoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile as HttpUploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class VideoServiceTest extends TestCase
{
    use RefreshDatabase;

    private VideoService $videoService;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        
        $this->videoService = app()->make(VideoService::class);
    }

    public function test_destroy_video(): void
    {
        $video = \App\Models\Video::factory()->create([
            'video' => Storage::put('videos', HttpUploadedFile::fake()->create('movie.mp4', 1024, 'video/mp4')),
        ]);

        $this->videoService->destroy($video->id);

        Storage::disk('public')->assertMissing($video->video);

        $this->assertDatabaseMissing('videos', [
            'id' => $video->id,
        ]);
    }

    public function test_destroy_video_if_not_exist(): void
    {
        Video::query()->delete();

        try {
            $this->videoService->destroy(1);
        } catch (NotFoundHttpException $e) {
            $this->assertEquals($e->getStatusCode(), 404);
        }
    }
}
