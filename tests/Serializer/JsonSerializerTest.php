<?php

namespace Ngmy\EloquentSerializedLob\Tests\Serializer;

use Ngmy\EloquentSerializedLob\Tests\TestCase;
use Ngmy\EloquentSerializedLob\Tests\Fixtures\Entities\Bug;
use Ngmy\EloquentSerializedLob\Serializer\JsonSerializer;

class JsonSerializerTest extends TestCase
{
    public function test_Should_SerializeGivenObjectToJsonFormattedString()
    {
        $inputBug = new Bug;
        $inputBug->setSeverity('loss of functionality');
        $inputBug->setVersionAffected('1.0');

        $serializer = new JsonSerializer;
        $actualBugJson = $serializer->serialize($inputBug);

        $expectedBugJson = <<<EOF
{"severity":"loss of functionality","version_affected":"1.0"}
EOF;

        $this->assertEquals($expectedBugJson, $actualBugJson);
    }

    public function test_Should_DeserializeGivenJsonFormattedStringToObject()
    {
        $inputBugJson = <<<EOF
{"severity":"loss of functionality","version_affected":"1.0"}
EOF;

        $serializer = new JsonSerializer;
        $actualBug = $serializer->deserialize($inputBugJson, Bug::class);

        $expectedBug = new Bug;
        $expectedBug->setSeverity('loss of functionality');
        $expectedBug->setVersionAffected('1.0');

        $this->assertEquals($expectedBug, $actualBug);
    }
}
