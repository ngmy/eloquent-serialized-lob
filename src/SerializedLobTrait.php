<?php

declare(strict_types=1);

namespace Ngmy\EloquentSerializedLob;

use Ngmy\EloquentSerializedLob\Serializers\SerializerFactory;

trait SerializedLobTrait
{
    /**
     * @param string $key
     * @return mixed
     * @see \Illuminate\Database\Eloquent\Concerns\HasAttributes::getAttribute()
     */
    public function getAttribute($key)
    {
        if ($key == $this->getSerializationColumn()) {
            $serializer = SerializerFactory::get($this->getSerializationType());
            return $serializer->deserialize(parent::getAttribute($key), $this->getDeserializationType());
        } else {
            return parent::getAttribute($key);
        }
    }

    /**
     * @param string $key
     * @param mixed  $value
     * @see \Illuminate\Database\Eloquent\Concerns\HasAttributes::getAttribute()
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        if ($key == $this->getSerializationColumn()) {
            $serializer = SerializerFactory::get($this->getSerializationType());
            return parent::setAttribute($key, $serializer->serialize($value));
        } else {
            return parent::setAttribute($key, $value);
        }
    }

    /**
     * @return string
     */
    abstract protected function getSerializationColumn(): string;

    /**
     * @return string
     */
    abstract protected function getSerializationType(): string;

    /**
     * @return string
     */
    abstract protected function getDeserializationType(): string;
}
