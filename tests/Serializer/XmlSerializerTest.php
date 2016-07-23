<?php

namespace Ngmy\EloquentSerializedLob\Tests\Serializer;

use Ngmy\EloquentSerializedLob\Tests\TestCase;
use Ngmy\EloquentSerializedLob\Tests\Fixtures\Entities\Bug;
use Ngmy\EloquentSerializedLob\Serializer\XmlSerializer;

class XmlSerializerTest extends TestCase
{
    public function test_Should_SerializeGivenObjectToXmlFormattedString()
    {
        $inputBug = new Bug;
        $inputBug->setSeverity('loss of functionality');
        $inputBug->setVersionAffected('1.0');

        $serializer = new XmlSerializer;
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

    public function test_Should_DeserializeGivenXmlFormattedStringToObject()
    {
        $inputBugXml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<result>
  <severity><![CDATA[loss of functionality]]></severity>
  <version_affected><![CDATA[1.0]]></version_affected>
</result>

EOF;

        $serializer = new XmlSerializer;
        $actualBug = $serializer->deserialize($inputBugXml, Bug::class);

        $expectedBug = new Bug;
        $expectedBug->setSeverity('loss of functionality');
        $expectedBug->setVersionAffected('1.0');

        $this->assertEquals($expectedBug, $actualBug);
    }
}
