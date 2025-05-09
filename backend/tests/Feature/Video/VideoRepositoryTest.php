<?php

declare(strict_types=1);

namespace Tests\Feature\Video;

use App\Models\Video;
use App\Repositories\Contracts\VideoRepositoryContract;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VideoRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private VideoRepositoryContract $videoRepository;

    protected function setUp(): void
    {
        $this->withExceptionHandling();

        parent::setUp();

        $this->videoRepository = app()->make(VideoRepositoryContract::class);
    }

    public function test_storing_a_video_successful(): void
    {
        $video = Video::factory()->make()->toArray();

        $data = $this->videoRepository->store($video);

        $this->assertSame($data['video'], $video['video']);
        $this->assertDatabaseHas('videos', $video);
    }
}
