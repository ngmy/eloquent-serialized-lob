<?php

declare(strict_types=1);

namespace Ngmy\EloquentSerializedLob\Tests\Serializers;

use InvalidArgumentException;
use Ngmy\EloquentSerializedLob\Serializers\JsonSerializer;
use Ngmy\EloquentSerializedLob\Serializers\SerializerFactory;
use Ngmy\EloquentSerializedLob\Serializers\SerializerInterface;
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
     * @dataProvider providerMake
     *
     * @phpstan-param 'json'|'xml'|class-string<SerializerInterface> $type
     * @phpstan-param class-string<SerializerInterface> $expected
     *
     * @psalm-param 'json'|'xml'|class-string<SerializerInterface> $type
     * @psalm-param class-string<SerializerInterface> $expected
     */
    public function testMake(string $type, string $expected): void
    {
        $serializer = SerializerFactory::make($type);

        $this->assertInstanceOf($expected, $serializer);
    }

    public function testMakeThrowsAnExceptionWhenAClassNameThatDoesNotImplementTheSerializerInterfaceIsSpecified(): void
    {
        $this->expectException(InvalidArgumentException::class);

        // NOTE: To test that an exception is thrown
        // @phpstan-ignore-next-line
        SerializerFactory::make(stdClass::class);
    }

    public function testMakeThrowsAnExceptionWhenAnInvalidTypeIsSpecified(): void
    {
        $this->expectException(InvalidArgumentException::class);

        // NOTE: To test that an exception is thrown
        // @phpstan-ignore-next-line
        SerializerFactory::make('invalid');
    }
}
