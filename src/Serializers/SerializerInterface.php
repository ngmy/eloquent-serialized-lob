<?php

declare(strict_types=1);

namespace Ngmy\EloquentSerializedLob\Serializers;

interface SerializerInterface
{
    /**
     * @param array<mixed>|object $value
     */
    public function serialize($value): string;

    /**
     * @return array<mixed>|object
     */
    public function deserialize(string $value, string $type);
}
