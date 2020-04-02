<?php

declare(strict_types=1);

namespace Ngmy\EloquentSerializedLob\Serializers;

use BadMethodCallException;
use InvalidArgumentException;

class SerializerFactory
{
    /** @var array<string, SerializerInterface> */
    private static $cache = [];

    /**
     * @param string $type
     * @return SerializerInterface
     */
    public static function get(string $type): SerializerInterface
    {
        if (empty(self::$cache[$type])) {
            self::$cache[$type] = self::make($type);
        }

        return self::$cache[$type];
    }

    /**
     * @param string $type
     * @return SerializerInterface
     * @throws InvalidArgumentException
     */
    public static function make(string $type): SerializerInterface
    {
        if (strtolower($type) == 'json') {
            return app()->make(JsonSerializer::class);
        } elseif (strtolower($type) == 'xml') {
            return app()->make(XmlSerializer::class);
        } elseif (class_exists($type)) {
            $serializer = app()->make($type);
            if (!$serializer instanceof SerializerInterface) {
                throw new InvalidArgumentException(
                    'Serializer class must implement the ' . SerializerInterface::class . ' interface.' . PHP_EOL .
                    'type: ' . $type
                );
            }
            return $serializer;
        }

        throw new InvalidArgumentException(
            'Invalid type.' . PHP_EOL .
            'type: ' . $type
        );
    }

    /**
     * @return void
     * @throws BadMethodCallException
     */
    public function __clone()
    {
        throw new BadMethodCallException(
            'This class is a singleton class, you are not allowed to clone it.' . PHP_EOL .
            'Please call ' . get_class($this) . '::getInstance() to get a reference to ' .
            'the only instance of the ' . get_class($this) . ' class.'
        );
    }

    /**
     * @return void
     * @throws BadMethodCallException
     */
    public function __wakeup(): void
    {
        throw new BadMethodCallException(
            'This class is a singleton class, you are not allowed to unserialize ' .
            'it as this could create a new instance of it.' . PHP_EOL .
            'Please call ' . get_class($this) . '::getInstance() to get a reference to ' .
            'the only instance of the ' . get_class($this) . ' class.'
        );
    }

    /**
     * @return void
     */
    private function __construct()
    {
    }
}
