<?php

declare(strict_types=1);

namespace Ngmy\EloquentSerializedLob\Tests\SampleProjects\OrganizationHierarchy\Entities;

use JMS\Serializer\Annotation\{
    Accessor,
    Type,
};

class Department
{
    /**
     * @var string
     * @Type("string")
     * @Accessor(getter="getName",setter="setName")
     */
    private $name;
    /**
     * @var array<int, Department>|null
     * @Type("array<Ngmy\EloquentSerializedLob\Tests\SampleProjects\OrganizationHierarchy\Entities\Department>")
     * @Accessor(getter="getSubsidiaries",setter="setSubsidiaries")
     */
    private $subsidiaries;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array<int, Department>|null
     */
    public function getSubsidiaries(): ?array
    {
        return $this->subsidiaries;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param array<Department> $subsidiaries
     * @return void
     */
    public function setSubsidiaries(array $subsidiaries): void
    {
        $this->subsidiaries = $subsidiaries;
    }

    /**
     * @param Department $subsidiary
     * @return void
     */
    public function addSubsidiary(Department $subsidiary): void
    {
        if (is_null($this->subsidiaries)) {
            $this->subsidiaries = [];
        }
        $this->subsidiaries[] = $subsidiary;
    }
}
