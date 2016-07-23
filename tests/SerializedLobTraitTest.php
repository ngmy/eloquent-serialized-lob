<?php

namespace Ngmy\EloquentSerializedLob\Tests;

use Ngmy\EloquentSerializedLob\Tests\TestCase;
use Ngmy\EloquentSerializedLob\Tests\Fixtures\Entities\Bug;
use Ngmy\EloquentSerializedLob\Tests\Fixtures\Entities\Department;
use Ngmy\EloquentSerializedLob\Tests\Fixtures\Entities\FeatureRequest;
use Ngmy\EloquentSerializedLob\Tests\Fixtures\Models\Customer;
use Ngmy\EloquentSerializedLob\Tests\Fixtures\Models\Issue;
use Illuminate\Database\Schema\Query;

class SerializedLobTraitTest extends TestCase
{
    protected $useDatabase = true;

    public function test_Should_SetSerializationOfAttribute_When_StoringGraphOfObjectsInOneTable()
    {
        $area = new Department;
        $area->setName('area');

        $area1 = new Department;
        $area1->setName('area1');

        $area1_1 = new Department;
        $area1_1->setName('area1_1');

        $area1->addSubsidiaries($area1_1);
        $area->addSubsidiaries($area1);

        $customer = new Customer;
        $customer->name = 'Customer';
        $customer->departments = $area;

        $customer->save();

        $createdCustomer = $this->db->table('customers')->where('id', 1)->first();

        $expectedDepartmentsXml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<result>
  <name><![CDATA[area]]></name>
  <subsidiaries>
    <entry>
      <name><![CDATA[area1]]></name>
      <subsidiaries>
        <entry>
          <name><![CDATA[area1_1]]></name>
        </entry>
      </subsidiaries>
    </entry>
  </subsidiaries>
</result>

EOF;

        $this->assertEquals('Customer', $createdCustomer->name);
        $this->assertEquals($expectedDepartmentsXml, $createdCustomer->departments);
    }

    public function test_Should_GetDeserializationOfAttribute_When_StoringGraphOfObjectsInOneTable()
    {
        $departmentsXml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<result>
  <name><![CDATA[area]]></name>
  <subsidiaries>
    <entry>
      <name><![CDATA[area1]]></name>
      <subsidiaries>
        <entry>
          <name><![CDATA[area1_1]]></name>
        </entry>
      </subsidiaries>
    </entry>
  </subsidiaries>
</result>

EOF;

        $this->db->table('customers')->insert([
            'name' => 'Customer',
            'departments' => $departmentsXml,
        ]);

        $readCustomer = Customer::find(1);

        $this->assertEquals('Customer', $readCustomer->name);
        $this->assertEquals('area', $readCustomer->departments->getName());
        $this->assertEquals('area1', $readCustomer->departments->getSubsidiaries()[0]->getName());
        $this->assertEquals('area1_1', $readCustomer->departments->getSubsidiaries()[0]->getSubsidiaries()[0]->getName());
    }

    public function test_Should_SetSerializationOfAttribute_When_StoringSubtypesOfObjectInOneTable()
    {
        // issue_type is 'bug'.
        $bug = new Bug;
        $bug->setSeverity('loss of functionality');
        $bug->setVersionAffected('1.0');

        $issueBug = new Issue;
        $issueBug->reported_by = 1;
        $issueBug->product_id = 1;
        $issueBug->priority = 'high';
        $issueBug->version_resolved = null;
        $issueBug->status = 'new';
        $issueBug->issue_type = 'bug';
        $issueBug->attributes = $bug;

        $issueBug->save();

        // issue_type is 'feature'.
        $featureRequest = new FeatureRequest;
        $featureRequest->setSponsor('Sponsor');

        $issueFeature = new Issue;
        $issueFeature->reported_by = 1;
        $issueFeature->product_id = 1;
        $issueFeature->priority = 'high';
        $issueFeature->version_resolved = null;
        $issueFeature->status = 'new';
        $issueFeature->issue_type = 'feature';
        $issueFeature->attributes = $featureRequest;

        $issueFeature->save();

        $createdIssueTypeBug = $this->db->table('issues')->where('id', 1)->first();
        $createdIssueTypeFeature = $this->db->table('issues')->where('id', 2)->first();

        $this->assertEquals(1, $createdIssueTypeBug->reported_by);
        $this->assertEquals(1, $createdIssueTypeBug->product_id);
        $this->assertEquals('high', $createdIssueTypeBug->priority);
        $this->assertEquals(null, $createdIssueTypeBug->version_resolved);
        $this->assertEquals('new', $createdIssueTypeBug->status);
        $this->assertEquals('bug', $createdIssueTypeBug->issue_type);
        $this->assertEquals('{"severity":"loss of functionality","version_affected":"1.0"}', $createdIssueTypeBug->attributes);

        $this->assertEquals(1, $createdIssueTypeFeature->reported_by);
        $this->assertEquals(1, $createdIssueTypeFeature->product_id);
        $this->assertEquals('high', $createdIssueTypeFeature->priority);
        $this->assertEquals(null, $createdIssueTypeFeature->version_resolved);
        $this->assertEquals('new', $createdIssueTypeFeature->status);
        $this->assertEquals('feature', $createdIssueTypeFeature->issue_type);
        $this->assertEquals('{"sponsor":"Sponsor"}', $createdIssueTypeFeature->attributes);
    }

    public function test_Should_GetDeserializationOfAttribute_When_StoringSubtypesOfObjectInOneTable()
    {
        // issue_type is 'bug'.
        $this->db->table('issues')->insert([
            'reported_by' => 1,
            'product_id' => 1,
            'priority' => 'high',
            'version_resolved' => null,
            'status' => 'new',
            'issue_type' => 'bug',
            'attributes' => '{"severity":"loss of functionality","version_affected":"1.0"}',
        ]);

        // issue_type is 'feature'.
        $this->db->table('issues')->insert([
            'reported_by' => 1,
            'product_id' => 1,
            'priority' => 'high',
            'version_resolved' => null,
            'status' => 'new',
            'issue_type' => 'feature',
            'attributes' => '{"sponsor":"Sponsor"}',
        ]);

        // issue_type is an unexpected value.
        $this->db->table('issues')->insert([
            'reported_by' => 1,
            'product_id' => 1,
            'priority' => 'high',
            'version_resolved' => null,
            'status' => 'new',
            'issue_type' => 'unexpected',
            'attributes' => '{"key":"value"}',
        ]);

        // issue_type is null.
        $this->db->table('issues')->insert([
            'reported_by' => 1,
            'product_id' => 1,
            'priority' => 'high',
            'version_resolved' => null,
            'status' => 'new',
            'issue_type' => null,
            'attributes' => '{"key":"value"}',
        ]);

        $readIssueTypeBug = Issue::find(1);
        $readIssueTypeFeature = Issue::find(2);
        $readIssueTypeUnexpected = Issue::find(3);
        $readIssueTypeNull = Issue::find(4);

        $this->assertEquals(1, $readIssueTypeBug->reported_by);
        $this->assertEquals(1, $readIssueTypeBug->product_id);
        $this->assertEquals('high', $readIssueTypeBug->priority);
        $this->assertEquals(null, $readIssueTypeBug->version_resolved);
        $this->assertEquals('new', $readIssueTypeBug->status);
        $this->assertEquals('bug', $readIssueTypeBug->issue_type);
        $this->assertEquals('loss of functionality', $readIssueTypeBug->attributes->getSeverity());
        $this->assertEquals('1.0', $readIssueTypeBug->attributes->getVersionAffected());

        $this->assertEquals(1, $readIssueTypeFeature->reported_by);
        $this->assertEquals(1, $readIssueTypeFeature->product_id);
        $this->assertEquals('high', $readIssueTypeFeature->priority);
        $this->assertEquals(null, $readIssueTypeFeature->version_resolved);
        $this->assertEquals('new', $readIssueTypeFeature->status);
        $this->assertEquals('feature', $readIssueTypeFeature->issue_type);
        $this->assertEquals('Sponsor', $readIssueTypeFeature->attributes->getSponsor());

        $this->assertEquals(1, $readIssueTypeUnexpected->reported_by);
        $this->assertEquals(1, $readIssueTypeUnexpected->product_id);
        $this->assertEquals('high', $readIssueTypeUnexpected->priority);
        $this->assertEquals(null, $readIssueTypeUnexpected->version_resolved);
        $this->assertEquals('new', $readIssueTypeUnexpected->status);
        $this->assertEquals('unexpected', $readIssueTypeUnexpected->issue_type);
        $this->assertEquals('value', $readIssueTypeUnexpected->attributes['key']);

        $this->assertEquals(1, $readIssueTypeNull->reported_by);
        $this->assertEquals(1, $readIssueTypeNull->product_id);
        $this->assertEquals('high', $readIssueTypeNull->priority);
        $this->assertEquals(null, $readIssueTypeNull->version_resolved);
        $this->assertEquals('new', $readIssueTypeNull->status);
        $this->assertEquals(null, $readIssueTypeNull->issue_type);
        $this->assertEquals('value', $readIssueTypeNull->attributes['key']);
    }
}
