<?php

namespace Tests\Unit;

use App\DTOs\Movie\MovieDTO;
use App\DTOs\Video\VideoDTO;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Traits\AssertDTOData;

class MovieDTOTest extends TestCase
{
    use AssertDTOData;

    public function test_creating_a_movie_DTO(): void
    {
        $videoDTO = new VideoDTO(1, 'some/path/video.mp4');

        $data = [
            'id' => 1,
            'title' => fake()->word(),
            'description' => fake()->text(),
            'image' => fake()->filePath(),
            'video' => $videoDTO,
        ];

        $this->assertCreatingDTOFromConstructor(MovieDTO::class, $data);
    }

    public function test_creating_a_movie_DTO_from_array(): void
    {
        $videoDTO = new VideoDTO(1, 'some/path/video.mp4');

        $data = [
            'id' => 1,
            'title' => fake()->word(),
            'description' => fake()->text(),
            'image' => fake()->filePath(),
            'video' => $videoDTO,
        ];

        $this->assertCreateDTOFromArray(MovieDTO::class, $data);
    }

    public function test_decode_a_movie_DTO_to_Array(): void
    {
        $data = [
            'id' => 1,
            'title' => fake()->word(),
            'description' => fake()->text(),
            'image' => fake()->filePath(),
            'video' => [
                'id' => 1,
                'video' => fake()->filePath(),
            ],
        ];

        $this->assertDecodeDTOToArray(MovieDTO::class, $data);
    }
}
