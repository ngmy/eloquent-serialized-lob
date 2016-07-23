<?php

namespace Ngmy\EloquentSerializedLob\Tests\Fixtures\Models;

use Ngmy\EloquentSerializedLob\SerializedLobTrait;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use SerializedLobTrait;

    protected $fillable = [
        'name',
        'departments',
    ];

    protected function serializedLobColumn()
    {
        return 'departments';
    }

    protected function serializedLobSerializer()
    {
        return \Ngmy\EloquentSerializedLob\Serializer\XmlSerializer::class;
    }

    protected function serializedLobDeserializeType()
    {
        return \Ngmy\EloquentSerializedLob\Tests\Fixtures\Entities\Department::class;
    }
}
