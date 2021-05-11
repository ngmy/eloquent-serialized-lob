<?php

declare(strict_types=1);

namespace Ngmy\EloquentSerializedLob\Tests\Serializers;

use Ngmy\EloquentSerializedLob\Serializers\JsonSerializer;
use Ngmy\EloquentSerializedLob\Tests\SampleProjects\IssueDatabase\Entities\Bug;
use Ngmy\EloquentSerializedLob\Tests\TestCase;

class JsonSerializerTest extends TestCase
{
    public function testShouldSerializeGivenObjectToJsonFormattedString(): void
    {
        $inputBug = new Bug();
        $inputBug->setSeverity('loss of functionality');
        $inputBug->setVersionAffected('1.0');

        $serializer = $this->app->make(JsonSerializer::class);
        $actualBugJson = $serializer->serialize($inputBug);

        $expectedBugJson = <<<EOF
{"severity":"loss of functionality","version_affected":"1.0"}
EOF;

        $this->assertEquals($expectedBugJson, $actualBugJson);
    }

    public function testShouldDeserializeGivenJsonFormattedStringToObject(): void
    {
        $inputBugJson = <<<EOF
{"severity":"loss of functionality","version_affected":"1.0"}
EOF;

        $serializer = $this->app->make(JsonSerializer::class);
        $actualBug = $serializer->deserialize($inputBugJson, Bug::class);

        $expectedBug = new Bug();
        $expectedBug->setSeverity('loss of functionality');
        $expectedBug->setVersionAffected('1.0');

        $this->assertEquals($expectedBug, $actualBug);
    }
}
