<?php

namespace App\DTOs;

abstract class DTO
{
    public static function fromArray(array $data): self
    {
        return new static(...$data);
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}