<?php

namespace Tests\Unit\Traits;

trait AssertDTOData
{
    public function assertCreatingDTOFromConstructor(string $dtoClass, array $data): void
    {
        $dto = new $dtoClass(...$data);

        foreach ($data as $key => $value) {
            $this->assertSame($value, $dto->{$key}, "DTO property '{$key}' does not match expected value.");
        }
    }

    public function assertCreateDTOFromArray(string $dtoClass, array $data): void
    {
        $dto = $dtoClass::fromArray($data);

        foreach ($data as $key => $value) {
            $this->assertSame($value, $dto->{$key}, "DTO property '{$key}' does not match expected value.");
        }
    }

    public function assertDecodeDTOToArray(string $dtoClass, array $data): void
    {
        $dto = $dtoClass::fromArray($data);
        $arrDTO = $dto->toArray();
    
        foreach ($data as $key => $value) {
            $this->assertSame($value, $arrDTO[$key] ?? null, "Array DTO property '{$key}' does not match expected value.");
        }
    }
}