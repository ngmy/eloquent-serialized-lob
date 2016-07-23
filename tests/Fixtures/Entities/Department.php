<?php

namespace Ngmy\EloquentSerializedLob\Tests\Fixtures\Entities;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;

class Department
{
    /**
     * @Type("string")
     * @Accessor(getter="getName",setter="setName")
     */
    protected $name;

    /**
     * @Type("array<Ngmy\EloquentSerializedLob\Tests\Fixtures\Entities\Department>")
     * @Accessor(getter="getSubsidiaries",setter="setSubsidiaries")
     */
    protected $subsidiaries;

    public function getName()
    {
        return $this->name;
    }

    public function getSubsidiaries()
    {
        return $this->subsidiaries;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setSubsidiaries(array $subsidiaries)
    {
        $this->subsidiaries = $subsidiaries;
    }

    public function addSubsidiaries(Department $department)
    {
        if (is_null($this->subsidiaries)) {
            $this->subsidiaries = [];
        }

        $this->subsidiaries[] = $department;
    }
}
