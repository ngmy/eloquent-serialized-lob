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
     * @return mixed
     *
     * @phpstan-template T
     * @phpstan-param class-string<T> $type
     * @phpstan-return T
     *
     * @psalm-template T
     * @psalm-param class-string<T> $type
     * @psalm-return T
     */
    public function deserialize(string $value, string $type);
}
