<?php

declare(strict_types=1);

namespace Ngmy\EloquentSerializedLob\Serializers;

use BadMethodCallException;
use Illuminate\Contracts\Foundation\Application;
use InvalidArgumentException;

use function class_exists;
use function get_class;
use function strtolower;

use const PHP_EOL;

class SerializerFactory
{
    /** @var array<string, SerializerInterface> */
    private static $cache = [];

    /**
     * @throws InvalidArgumentException
     *
     * @phpstan-param 'json'|'xml'|class-string<SerializerInterface> $type
     *
     * @psalm-template TSerializer of SerializerInterface
     * @psalm-template TType of string|class-string<TSerializer>
     * @psalm-param TType $type
     * @psalm-return (
     *      TType is 'json'
     *          ? JsonSerializer
     *          : (TType is 'xml' ? XmlSerializer : TSerializer)
     * )
     */
    public static function get(string $type): SerializerInterface
    {
        if (empty(self::$cache[$type])) {
            self::$cache[$type] = self::make($type);
        }

        /**
         * @psalm-var (
         *      TType is 'json'
         *          ? JsonSerializer
         *          : (TType is 'xml' ? XmlSerializer : TSerializer)
         */
        return self::$cache[$type];
    }

    /**
     * @throws InvalidArgumentException
     *
     * @phpstan-param 'json'|'xml'|class-string<SerializerInterface> $type
     *
     * @psalm-template TSerializer of SerializerInterface
     * @psalm-template TType of string|class-string<TSerializer>
     * @psalm-param TType $type
     * @psalm-return (
     *      TType is 'json'
     *          ? JsonSerializer
     *          : (TType is 'xml' ? XmlSerializer : TSerializer)
     * )
     */
    public static function make(string $type): SerializerInterface
    {
        /** @psalm-var Application */
        $app = app();
        if (strtolower($type) == 'json') {
            /** @psalm-var JsonSerializer */
            return $app->make(JsonSerializer::class);
        } elseif (strtolower($type) == 'xml') {
            /** @psalm-var XmlSerializer */
            return $app->make(XmlSerializer::class);
        } elseif (class_exists($type)) {
            $serializer = $app->make($type);
            if (!$serializer instanceof SerializerInterface) {
                throw new InvalidArgumentException(
                    'Serializer class must implement the ' . SerializerInterface::class . ' interface.' . PHP_EOL .
                    'type: ' . $type
                );
            }
            /** @psalm-var TSerializer */
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

    private function __construct()
    {
    }
}
