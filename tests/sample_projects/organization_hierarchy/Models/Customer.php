<?php

declare(strict_types=1);

namespace Ngmy\EloquentSerializedLob\Tests\SampleProjects\OrganizationHierarchy\Models;

use Eloquent;
use Illuminate\Database\Eloquent\{
    Builder,
    Model,
};
use Illuminate\Support\Carbon;
use Ngmy\EloquentSerializedLob\SerializedLobTrait;
use Ngmy\EloquentSerializedLob\Serializer\XmlSerializer;
use Ngmy\EloquentSerializedLob\Tests\SampleProjects\OrganizationHierarchy\Entities\Department;

/**
 * Ngmy\EloquentSerializedLob\Tests\SampleProjects\OrganizationHierarchy\Models\Customer
 *
 * @property int $id
 * @property string $name
 * @property Department $departments
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Customer newModelQuery()
 * @method static Builder|Customer newQuery()
 * @method static Builder|Customer query()
 * @method static Builder|Customer whereCreatedAt($value)
 * @method static Builder|Customer whereDepartments($value)
 * @method static Builder|Customer whereId($value)
 * @method static Builder|Customer whereName($value)
 * @method static Builder|Customer whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Customer extends Model
{
    use SerializedLobTrait;

    /** @var array<string> */
    protected $fillable = [
        'name',
        'departments',
    ];

    protected function getSerializationColumn(): string
    {
        return 'departments';
    }

    protected function getSerializationType(): string
    {
        return 'xml';
    }

    protected function getDeserializationType(): string
    {
        return Department::class;
    }
}
