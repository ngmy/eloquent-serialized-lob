<?php

namespace Ngmy\EloquentSerializedLob\Tests\Fixtures\Entities;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;

class FeatureRequest
{
    /**
     * @Type("string")
     * @Accessor(getter="getSponsor",setter="setSponsor")
     */
    protected $sponsor;

    public function getSponsor()
    {
        return $this->sponsor;
    }

    public function setSponsor($sponsor)
    {
        $this->sponsor = $sponsor;
    }
}
