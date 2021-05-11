<?php

declare(strict_types=1);

namespace Ngmy\EloquentSerializedLob\Serializers;

use BadMethodCallException;
use InvalidArgumentException;

use function class_exists;
use function get_class;
use function strtolower;

use const PHP_EOL;

class SerializerFactory
{
    /** @var array<string, SerializerInterface> */
    private static $cache = [];

    public static function get(string $type): SerializerInterface
    {
        if (empty(self::$cache[$type])) {
            self::$cache[$type] = self::make($type);
        }

        return self::$cache[$type];
    }

    /**
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
     * @throws BadMethodCallException
     * @return void
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
