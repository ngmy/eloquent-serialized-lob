<?php

namespace Ngmy\EloquentSerializedLob\Serializer;

interface SerializerInterface
{
    /**
     * Serialize the given object|array to a formatted string.
     *
     * @param object|array $value An object|array to serialize to a formatted string.
     * @return string A formatted string.
     */
    public function serialize($value);

    /**
     * Deserialize the given formatted string to an object|array of the given type.
     *
     * @param string $value A formatted string.
     * @param string $type  A type to deserialize to.
     * @return object|array An object|array of the given type.
     */
    public function deserialize($value, $type);
}
