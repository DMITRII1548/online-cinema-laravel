<?php

namespace Tests\Unit;

use App\DTOs\Video\VideoDTO;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Traits\AssertDTOData;

class VideoDTOTest extends TestCase
{
    use AssertDTOData;

    public function test_creating_a_form_movie_DTO(): void
    {
        $data = [
            'id' => fake()->numberBetween(1),
            'video' => fake()->filePath(),
        ];

        $this->assertCreatingDTOFromConstructor(VideoDTO::class, $data);
    }

    public function test_creating_a_form_movie_DTO_from_array(): void
    {
        $data = [
            'id' => fake()->numberBetween(1),
            'video' => fake()->filePath(),
        ];

        $this->assertCreateDTOFromArray(VideoDTO::class, $data);
    }

    public function test_decode_a_form_movie_DTO_to_Array(): void
    {
        $data = [
            'id' => fake()->numberBetween(1),
            'video' => fake()->filePath(),
        ];

        $this->assertDecodeDTOToArray(VideoDTO::class, $data);
    }
}
