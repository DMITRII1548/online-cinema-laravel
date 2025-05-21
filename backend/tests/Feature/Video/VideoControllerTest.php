<?php

declare(strict_types=1);

namespace Tests\Feature\Video;

use App\Models\Role;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VideoControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        Storage::fake('private');

        $role = Role::firstOrCreate(['name' => 'admin']);
        $user = User::factory()->create();
        $user->roles()->sync($role);

        $this->actingAs($user);
    }

    public function test_showing_a_video_if_exists(): void
    {
        $video = Video::factory()->create();

        $response = $this->get("/api/videos/{$video->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id', 
                'video',
            ])
            ->assertJsonPath('id', $video->id)
            ->assertJsonPath('video', url('') . '/storage/' . $video->video);
    }

    public function test_showing_a_video_if_not_exists(): void
    {
        Video::query()->delete();

        $response = $this->get('/api/videos/1');

        $response->assertStatus(404);
    }

    public function test_storing_chunk_successful(): void
    {
        $file = UploadedFile::fake()->create('video.mp4', 1000, 'video/mp4');

        $response = $this->post('/api/videos', [
            'video' => $file,
            'resumableChunkNumber' => 1,
            'resumableTotalChunks' => 3,
            'resumableIdentifier' => 'video123',
            'resumableFilename' => 'video.mp4',
            'resumableChunkSize' => 1024 * 1024,
            'resumableTotalSize' => $file->getSize(),
            'resumableRelativePath' => 'video.mp4',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['done', 'status'])
            ->assertJson(['status' => true]);
    }

    public function test_storing_all_chunks_successful(): void
    {
        $file = UploadedFile::fake()->create('video.mp4', 1000, 'video/mp4');

        $response = $this->post('/api/videos', [
            'video' => $file,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => ['id', 'video']]);
    }

    public function test_destroying_video_successful_if_exists(): void
    {
        $video = Video::factory()->create([
            'id' => 1,
            'video' => 'video.mp4',
        ]);

        $response = $this->delete("/api/videos/{$video->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Video deleted successfully',]);
    }

    public function test_destroying_video_if_not_exist(): void
    {
        Video::query()->delete();

        $response = $this->delete('/api/videos/1');

        $response->assertStatus(404);
    }
}
