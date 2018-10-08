<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\CheckProxy
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $proxy_id
 * @property Carbon|null $checked_at
 * @property int $status
 * @method static Builder|self whereCheckedAt($value)
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereProxyId($value)
 * @method static Builder|self whereStatus($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read Proxy $proxy
 */
class CheckProxy extends Model
{
    public const STATUS_OK = 100;
    public const STATUS_BAD = 200;

    protected $fillable = ['checked_at', 'status'];

    public function proxy(): BelongsTo
    {
        return $this->belongsTo(Proxy::class);
    }
}
