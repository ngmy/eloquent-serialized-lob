<?php

declare(strict_types=1);

namespace Ngmy\EloquentSerializedLob\Tests\SampleProjects\OrganizationHierarchy\Entities;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Type;

use function is_null;

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

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param array<Department> $subsidiaries
     */
    public function setSubsidiaries(array $subsidiaries): void
    {
        $this->subsidiaries = $subsidiaries;
    }

    public function addSubsidiary(Department $subsidiary): void
    {
        if (is_null($this->subsidiaries)) {
            $this->subsidiaries = [];
        }
        $this->subsidiaries[] = $subsidiary;
    }
}
