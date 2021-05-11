<?php

declare(strict_types=1);

namespace Ngmy\EloquentSerializedLob\Tests\SampleProjects\IssueDatabase\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Ngmy\EloquentSerializedLob\SerializedLobTrait;
use Ngmy\EloquentSerializedLob\Tests\SampleProjects\IssueDatabase\Entities\Bug;
use Ngmy\EloquentSerializedLob\Tests\SampleProjects\IssueDatabase\Entities\FeatureRequest;

/**
 * Ngmy\EloquentSerializedLob\Tests\SampleProjects\IssueDatabase\Models\Issue
 *
 * @property int $id
 * @property int $reported_by
 * @property int|null $product_id
 * @property string|null $priority
 * @property string|null $version_resolved
 * @property string|null $status
 * @property string|null $issue_type
 * @property array|Bug|FeatureRequest $attributes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Issue newModelQuery()
 * @method static Builder|Issue newQuery()
 * @method static Builder|Issue query()
 * @method static Builder|Issue whereAttributes($value)
 * @method static Builder|Issue whereCreatedAt($value)
 * @method static Builder|Issue whereId($value)
 * @method static Builder|Issue whereIssueType($value)
 * @method static Builder|Issue wherePriority($value)
 * @method static Builder|Issue whereProductId($value)
 * @method static Builder|Issue whereReportedBy($value)
 * @method static Builder|Issue whereStatus($value)
 * @method static Builder|Issue whereUpdatedAt($value)
 * @method static Builder|Issue whereVersionResolved($value)
 * @mixin Eloquent
 */
class Issue extends Model
{
    use SerializedLobTrait;

    /** @var array<string> */
    protected $fillable = [
        'reported_by',
        'product_id',
        'priority',
        'version_resolved',
        'status',
        'issue_type',
        'attributes',
    ];

    protected function getSerializationColumn(): string
    {
        return 'attributes';
    }

    protected function getSerializationType(): string
    {
        return 'json';
    }

    protected function getDeserializationType(): string
    {
        if ($this->issue_type == 'bug') {
            return Bug::class;
        } elseif ($this->issue_type == 'feature') {
            return FeatureRequest::class;
        } else {
            // Guard for null or unexpected value.
            return 'array';
        }
    }
}
