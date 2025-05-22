<?php

declare(strict_types=1);

namespace Tests\Feature\Video;

use App\DTOs\Video\VideoDTO;
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

    public function test_find_a_video_if_exists(): void
    {
        $video = Video::factory()->create();

        $data = $this->videoService->find($video->id);

        $this->assertTrue($data instanceof VideoDTO);
    }

    public function test_find_a_video_if_not_exists(): void
    {
        Video::query()->delete();

        try {
            $this->videoService->find(1);
        } catch (NotFoundHttpException $e) {
            $this->assertEquals($e->getStatusCode(), 404);
        }
    }

    public function test_calculate_max_pages(): void
    {
        Video::query()->delete();
        Video::factory(50)->create();

        $count = $this->videoService->calculateMaxPages(20);
        $this->assertEquals(3, $count);
    }

    public function test_paginate_videos_if_not_exist(): void
    {
        Video::query()->delete();

        $data = $this->videoService->paginate(1, 20);

        $this->assertEquals(collect([]), $data);
    }

    public function test_paginate_videos_if_exists(): void
    {
        Video::query()->delete();
        Video::factory(100)->create();

        $videos = Video::query()
            ->offset(0)
            ->limit(20)
            ->get()
            ->toArray();

        $videos = collect($videos)
            ->map(fn (array $video) => VideoDTO::fromArray($video));

        $data = $this->videoService->paginate(1, 20);

        $this->assertEquals($videos, $data);
    }

}
