<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Measurement
 *
 * @property int $id
 * @property int $session_id
 * @property float $temperature
 * @property int $sequence
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|Measurement newModelQuery()
 * @method static Builder|Measurement newQuery()
 * @method static Builder|Measurement query()
 * @method static Builder|Measurement whereCreatedAt($value)
 * @method static Builder|Measurement whereId($value)
 * @method static Builder|Measurement whereSequence($value)
 * @method static Builder|Measurement whereSessionId($value)
 * @method static Builder|Measurement whereTemperature($value)
 * @method static Builder|Measurement whereUpdatedAt($value)
 *
 * @mixin Builder<Measurement>
 */
class Measurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'temperature',
        'sequence',
    ];
}
