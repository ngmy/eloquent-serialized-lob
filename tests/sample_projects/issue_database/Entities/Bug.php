<?php

declare(strict_types=1);

namespace Ngmy\EloquentSerializedLob\Tests\SampleProjects\IssueDatabase\Entities;

use JMS\Serializer\Annotation\{
    Accessor,
    SerializedName,
    Type,
};

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

    /**
     * @return string
     */
    public function getSeverity(): string
    {
        return $this->severity;
    }

    /**
     * @return string
     */
    public function getVersionAffected(): string
    {
        return $this->versionAffected;
    }

    /**
     * @param string $severity
     * @return void
     */
    public function setSeverity(string $severity): void
    {
        $this->severity = $severity;
    }

    /**
     * @param string $versionAffected
     * @return void
     */
    public function setVersionAffected(string $versionAffected): void
    {
        $this->versionAffected = $versionAffected;
    }
}
