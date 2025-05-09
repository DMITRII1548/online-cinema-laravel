<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
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
}
