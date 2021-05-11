<?php

declare(strict_types=1);

namespace Ngmy\EloquentSerializedLob\Serializers;

use JMS\Serializer\SerializerInterface as JmsSerializerInterface;

class XmlSerializer implements SerializerInterface
{
    /** @var JmsSerializerInterface */
    protected $serializer;

    public function __construct(JmsSerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param array<mixed>|object $value
     */
    public function serialize($value): string
    {
        return $this->serializer->serialize($value, 'xml');
    }

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
    public function deserialize(string $value, string $type)
    {
        return $this->serializer->deserialize($value, $type, 'xml');
    }
}
