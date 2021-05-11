<?php

declare(strict_types=1);

namespace Ngmy\EloquentSerializedLob\Tests\SampleProjects\IssueDatabase\Entities;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;

class Bug
{
    /**
     * @var string
     * @Type("string")
     * @Accessor(getter="getSeverity",setter="setSeverity")
     */
    private $severity;
    /**
     * @var string
     * @Type("string")
     * @Accessor(getter="getVersionAffected",setter="setVersionAffected")
     * @SerializedName("version_affected")
     */
    private $versionAffected;

    public function getSeverity(): string
    {
        return $this->severity;
    }

    public function getVersionAffected(): string
    {
        return $this->versionAffected;
    }

    public function setSeverity(string $severity): void
    {
        $this->severity = $severity;
    }

    public function setVersionAffected(string $versionAffected): void
    {
        $this->versionAffected = $versionAffected;
    }
}
