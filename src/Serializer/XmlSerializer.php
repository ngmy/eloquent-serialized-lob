<?php

namespace Ngmy\EloquentSerializedLob\Serializer;

use Ngmy\EloquentSerializedLob\Serializer\SerializerInterface;
use JMS\Serializer\SerializerBuilder;

class XmlSerializer implements SerializerInterface
{
    /**
     * @var \JMS\Serializer\Serializer An instance of JMS\Serializer\Serializer.
     */
    protected $serializer;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->serializer = SerializerBuilder::create()->build();
    }

    /**
     * Serialize the given object|array to a XML formatted string.
     *
     * @param object|array $value An object|array to serialize to a XML formatted string.
     * @return string A XML formatted string.
     */
    public function serialize($value)
    {
        return $this->serializer->serialize($value, 'xml');
    }

    /**
     * Deserialize the given XML formatted string to an object|array of the given type.
     *
     * @param string $value A XML formatted string.
     * @param string $type  A type to deserialize to.
     * @return object|array An object|array of the given type.
     */
    public function deserialize($value, $type)
    {
        return $this->serializer->deserialize($value, $type, 'xml');
    }
}
