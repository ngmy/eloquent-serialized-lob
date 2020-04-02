<?php

declare(strict_types=1);

namespace Ngmy\EloquentSerializedLob\Serializers;

interface SerializerInterface
{
    /**
     * @param object|array<mixed> $value
     * @return string
     */
    public function serialize($value): string;

    /**
     * @param string $value
     * @param string $type
     * @return object|array<mixed>
     */
    public function deserialize(string $value, string $type);
}
