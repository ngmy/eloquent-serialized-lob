<?php

declare(strict_types=1);

namespace Ngmy\EloquentSerializedLob\Serializers;

use JMS\Serializer\SerializerInterface as JmsSerializerInterface;

class JsonSerializer implements SerializerInterface
{
    /** @var JmsSerializerInterface */
    protected $serializer;

    /**
     * @param JmsSerializerInterface $serializer
     * @return void
     */
    public function __construct(JmsSerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param object|array<mixed> $value
     * @return string
     */
    public function serialize($value): string
    {
        return $this->serializer->serialize($value, 'json');
    }

    /**
     * @template T
     * @param string          $value
     * @param class-string<T> $type
     * @return object|array<mixed>
     */
    public function deserialize(string $value, string $type)
    {
        return $this->serializer->deserialize($value, $type, 'json');
    }
}
