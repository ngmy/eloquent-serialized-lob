<?php

namespace Ngmy\EloquentSerializedLob\Tests\Fixtures\Entities;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;

class Bug
{
    /**
     * @Type("string")
     * @Accessor(getter="getSeverity",setter="setSeverity")
     */
    protected $severity;

    /**
     * @Type("string")
     * @Accessor(getter="getVersionAffected",setter="setVersionAffected")
     * @SerializedName("version_affected")
     */
    protected $versionAffected;

    public function getSeverity()
    {
        return $this->severity;
    }

    public function getVersionAffected()
    {
        return $this->versionAffected;
    }

    public function setSeverity($severity)
    {
        $this->severity = $severity;
    }

    public function setVersionAffected($versionAffected)
    {
        $this->versionAffected= $versionAffected;
    }
}
