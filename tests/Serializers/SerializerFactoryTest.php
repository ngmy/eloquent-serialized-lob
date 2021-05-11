<?php

declare(strict_types=1);

namespace Ngmy\EloquentSerializedLob\Tests\Serializers;

use InvalidArgumentException;
use Ngmy\EloquentSerializedLob\Serializers\JsonSerializer;
use Ngmy\EloquentSerializedLob\Serializers\SerializerFactory;
use Ngmy\EloquentSerializedLob\Serializers\XmlSerializer;
use Ngmy\EloquentSerializedLob\Tests\TestCase;
use stdClass;

class SerializerFactoryTest extends TestCase
{
    /**
     * @return array<string, array{type: string, expected: string}>
     */
    public function providerMake(): array
    {
        return [
            'Type is "json"' => [
                'type' => 'json',
                'expected' => JsonSerializer::class,
            ],
            'Type is "xml"' => [
                'type' => 'xml',
                'expected' => XmlSerializer::class,
            ],
            'Type is a class name' => [
                'type' => JsonSerializer::class,
                'expected' => JsonSerializer::class,
            ],
        ];
    }

    /**
     * @template ExpectedType of object
     * @param class-string<ExpectedType> $expected
     * @dataProvider providerMake
     */
    public function testMake(string $type, string $expected): void
    {
        $serializer = SerializerFactory::make($type);

        $this->assertInstanceOf($expected, $serializer);
    }

    public function testMakeThrowsAnExceptionWhenAClassNameThatDoesNotImplementTheSerializerInterfaceIsSpecified(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $serializer = SerializerFactory::make(stdClass::class);
    }

    public function testMakeThrowsAnExceptionWhenAnInvalidTypeIsSpecified(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $serializer = SerializerFactory::make('invalid');
    }
}
