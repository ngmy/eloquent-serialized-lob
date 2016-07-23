<?php

namespace Ngmy\EloquentSerializedLob;

trait SerializedLobTrait
{
    private static $serializedLobSerializerInstances;

    /**
     * Same as \Illuminate\Database\Eloquent::getAttribute,
     * but get a deserialization of an attribute if the given key is equal to the specified LOB column name.
     *
     * @param string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if ($key === $this->serializedLobColumn()) {
            $serializerClass = $this->serializedLobSerializer();
            $deserializeType = $this->serializedLobDeserializeType();
            return $this->getSerializedLobSerializerInstance($serializerClass)->deserialize(parent::getAttribute($key), $deserializeType);
        } else {
            return parent::getAttribute($key);
        }
    }

    /**
     * Same as \Illuminate\Database\Eloquent::setAttribute,
     * but set a serialization of the given value if the given key is equal to the specified LOB column name.
     *
     * @param string $key
     * @param mixed  $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        if ($key === $this->serializedLobColumn()) {
            $serializerClass = $this->serializedLobSerializer();
            return parent::setAttribute($key, $this->getSerializedLobSerializerInstance($serializerClass)->serialize($value));
        } else {
            return parent::setAttribute($key, $value);
        }
    }

    /**
     * Return a LOB column name to store serialization.
     *
     * @return string A LOB column name to store serialization.
     */
    abstract protected function serializedLobColumn();

    /**
     * Return a implementation class name of \Ngmy\EloquentSerializedLob\Serializer\SerializerInterface.
     *
     * @return string A implementation class name of \Ngmy\EloquentSerializedLob\Serializer\SerializerInterface.
     */
    abstract protected function serializedLobSerializer();

    /**
     * Return a type to deserialize to.
     *
     * @return string A type to deserialize to.
     */
    abstract protected function serializedLobDeserializeType();

    private function getSerializedLobSerializerInstance($serializerClass)
    {
        if (is_null(self::$serializedLobSerializerInstances[$serializerClass])) {
            self::$serializedLobSerializerInstances[$serializerClass] = new $serializerClass;
        }

        return self::$serializedLobSerializerInstances[$serializerClass];
    }
}
