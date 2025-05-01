<?php

namespace Tests\Unit;

use App\DTOs\Video\FormVideoDTO;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Traits\AssertDTOData;

class FormVideoDTOTest extends TestCase
{
    use AssertDTOData;

    public function test_creating_a_form_movie_DTO(): void
    {
        $data = [
            'video' => UploadedFile::fake()->create('video.mp4'),
        ];

        $this->assertCreatingDTOFromConstructor(FormVideoDTO::class, $data);
    }

    public function test_creating_a_form_movie_DTO_from_array(): void
    {
        $data = [
            'video' => UploadedFile::fake()->create('video.mp4'),
        ];

        $this->assertCreateDTOFromArray(FormVideoDTO::class, $data);
    }

    public function test_decode_a_form_movie_DTO_to_Array(): void
    {
        $data = [
            'video' => UploadedFile::fake()->create('video.mp4'),
        ];

        $this->assertDecodeDTOToArray(FormVideoDTO::class, $data);
    }
}
