<?php

namespace Ngmy\EloquentSerializedLob\Tests\Fixtures\Models;

use Ngmy\EloquentSerializedLob\SerializedLobTrait;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use SerializedLobTrait;

    protected $fillable = [
        'reported_by',
        'product_id',
        'priority',
        'version_resolved',
        'status',
        'issue_type',
        'attributes',
    ];

    protected function serializedLobColumn()
    {
        return 'attributes';
    }

    protected function serializedLobSerializer()
    {
        return \Ngmy\EloquentSerializedLob\Serializer\JsonSerializer::class;
    }

    protected function serializedLobDeserializeType()
    {
        if ($this->issue_type === 'bug') {
            return \Ngmy\EloquentSerializedLob\Tests\Fixtures\Entities\Bug::class;
        } elseif ($this->issue_type === 'feature') {
            return \Ngmy\EloquentSerializedLob\Tests\Fixtures\Entities\FeatureRequest::class;
        } else {
            // Guard for null or unexpected value.
            return 'array';
        }
    }
}
