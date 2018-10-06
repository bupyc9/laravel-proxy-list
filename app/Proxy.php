<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Proxy
 *
 * @mixin \Eloquent
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $ip_address
 * @property int $port
 * @property string $protocol
 * @property string $country
 * @property string $anonymity
 * @method static Builder|self whereAnonymity($value)
 * @method static Builder|self whereCountry($value)
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereIpAddress($value)
 * @method static Builder|self wherePort($value)
 * @method static Builder|self whereProtocol($value)
 * @method static Builder|self whereUpdatedAt($value)
 */
class Proxy extends Model
{
    public const ANONYMITY_ANONYMOUS = 1;
    public const ANONYMITY_NO = 2;
    public const ANONYMITY_HEIGHT = 3;

    protected $fillable = ['ip_address', 'port', 'protocol', 'country', 'anonymity'];
}
