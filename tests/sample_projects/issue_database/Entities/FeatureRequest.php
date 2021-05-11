<?php

declare(strict_types=1);

namespace Ngmy\EloquentSerializedLob\Tests\SampleProjects\IssueDatabase\Entities;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Type;

class FeatureRequest
{
    /**
     * @var string
     * @Type("string")
     * @Accessor(getter="getSponsor",setter="setSponsor")
     */
    private $sponsor;

    public function getSponsor(): string
    {
        return $this->sponsor;
    }

    public function setSponsor(string $sponsor): void
    {
        $this->sponsor = $sponsor;
    }
}
