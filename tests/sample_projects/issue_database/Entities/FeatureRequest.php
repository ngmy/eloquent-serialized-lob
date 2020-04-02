<?php

declare(strict_types=1);

namespace Ngmy\EloquentSerializedLob\Tests\SampleProjects\IssueDatabase\Entities;

use JMS\Serializer\Annotation\{
    Accessor,
    Type,
};

class FeatureRequest
{
    /**
     * @var string
     * @Type("string")
     * @Accessor(getter="getSponsor",setter="setSponsor")
     */
    private $sponsor;

    /**
     * @return string
     */
    public function getSponsor(): string
    {
        return $this->sponsor;
    }

    /**
     * @param string $sponsor
     * @return void
     */
    public function setSponsor(string $sponsor): void
    {
        $this->sponsor = $sponsor;
    }
}
