<?php

declare(strict_types=1);

namespace Tests\Unit\DTOs\Movie;

use App\DTOs\Movie\FormMovieDTO;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Traits\AssertDTOData;

class FormMovieDTOTest extends TestCase
{
    use AssertDTOData;

    public function test_creating_a_form_movie_DTO(): void
    {
        $data = [
            'title' => fake()->word(),
            'description' => fake()->text(),
            'image' => UploadedFile::fake()->create('img.png'),
            'video_id' => random_int(1, 1000),
        ];

        $this->assertCreatingDTOFromConstructor(FormMovieDTO::class, $data);
    }

    public function test_creating_a_form_movie_DTO_from_array(): void
    {
        $data = [
            'title' => fake()->word(),
            'description' => fake()->text(),
            'image' => UploadedFile::fake()->create('img.png'),
            'video_id' => random_int(1, 1000),
        ];

        $this->assertCreateDTOFromArray(FormMovieDTO::class, $data);
    }

    public function test_decode_a_form_movie_DTO_to_Array(): void
    {
        $data = [
            'title' => fake()->word(),
            'description' => fake()->text(),
            'image' => UploadedFile::fake()->create('img.png'),
            'video_id' => random_int(1, 1000),
        ];

        $this->assertDecodeDTOToArray(FormMovieDTO::class, $data);
    }
}
