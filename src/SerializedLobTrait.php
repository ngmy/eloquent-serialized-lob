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
     * @return $this
     * @see \Illuminate\Database\Eloquent\Concerns\HasAttributes::getAttribute()
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

    abstract protected function getSerializationColumn(): string;

    /**
     * @phpstan-return 'json'|'xml'|class-string<SerializerInterface>
     *
     * @psalm-return 'json'|'xml'|class-string<SerializerInterface>
     */
    abstract protected function getSerializationType(): string;

    /**
     * @phpstan-return class-string
     *
     * @psalm-return class-string
     */
    abstract protected function getDeserializationType(): string;
}
