<?php

declare(strict_types=1);

namespace Ngmy\EloquentSerializedLob\Tests\Serializers;

use Ngmy\EloquentSerializedLob\Serializers\XmlSerializer;
use Ngmy\EloquentSerializedLob\Tests\SampleProjects\IssueDatabase\Entities\Bug;
use Ngmy\EloquentSerializedLob\Tests\TestCase;

class XmlSerializerTest extends TestCase
{
    /**
     * @return void
     */
    public function testShouldSerializeGivenObjectToXmlFormattedString(): void
    {
        $inputBug = new Bug();
        $inputBug->setSeverity('loss of functionality');
        $inputBug->setVersionAffected('1.0');

        $serializer = $this->app->make(XmlSerializer::class);
        $actualBugXml = $serializer->serialize($inputBug);

        $expectedBugXml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<result>
  <severity><![CDATA[loss of functionality]]></severity>
  <version_affected><![CDATA[1.0]]></version_affected>
</result>

EOF;

        $this->assertEquals($expectedBugXml, $actualBugXml);
    }

    /**
     * @return void
     */
    public function testShouldDeserializeGivenXmlFormattedStringToObject(): void
    {
        $inputBugXml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<result>
  <severity><![CDATA[loss of functionality]]></severity>
  <version_affected><![CDATA[1.0]]></version_affected>
</result>

EOF;

        $serializer = $this->app->make(XmlSerializer::class);
        $actualBug = $serializer->deserialize($inputBugXml, Bug::class);

        $expectedBug = new Bug();
        $expectedBug->setSeverity('loss of functionality');
        $expectedBug->setVersionAffected('1.0');

        $this->assertEquals($expectedBug, $actualBug);
    }
}
