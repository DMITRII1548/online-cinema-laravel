<?php

declare(strict_types=1);

namespace App\DTOs;

use ReflectionClass;
use ReflectionNamedType;
use ReflectionProperty;

abstract class DTO
{
    public static function fromArray(array $data): static
    {
        $reflection = new ReflectionClass(static::class);
        $constructorArgs = [];

        foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $propertyName = $property->getName();

            if (isset($data[$propertyName])) {
                $type = $property->getType();

                if (
                    $type instanceof ReflectionNamedType &&
                    is_subclass_of($type->getName(), DTO::class)
                ) {
                    $constructorArgs[$propertyName] = $data[$propertyName] instanceof DTO
                        ? $data[$propertyName]
                        : $type->getName()::fromArray($data[$propertyName]);
                } else {
                    $constructorArgs[$propertyName] = $data[$propertyName];
                }
            }
        }

        return new static(...$constructorArgs);
    }

    public function toArray(): array
    {
        $objectVars = get_object_vars($this);

        foreach ($objectVars as $key => $value) {
            if ($value instanceof DTO) {
                $objectVars[$key] = $value->toArray();
            }
        }

        return $objectVars;
    }
}
