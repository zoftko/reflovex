<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\Session
 *
 * @property int $id
 * @property int $board_id
 * @property int $soak_temperature
 * @property int $soak_time
 * @property int $reflow_peak_temp
 * @property int $reflow_max_time
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Measurement> $measurements
 *
 * @method static Builder|Session newModelQuery()
 * @method static Builder|Session newQuery()
 * @method static Builder|Session query()
 * @method static Builder|Session whereBoardId($value)
 * @method static Builder|Session whereCreatedAt($value)
 * @method static Builder|Session whereId($value)
 * @method static Builder|Session whereReflowMaxTime($value)
 * @method static Builder|Session whereReflowPeakTemp($value)
 * @method static Builder|Session whereSoakTemperature($value)
 * @method static Builder|Session whereSoakTime($value)
 * @method static Builder|Session whereUpdatedAt($value)
 *
 * @mixin Builder<Session>
 */
class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'board_id',
        'soak_temperature',
        'soak_time',
        'reflow_max_time',
        'reflow_peak_temp',
    ];

    /**
     * Model's default values.
     *
     * @var int[]
     */
    protected $attributes = [
        'reflow_max_time' => 90,
    ];

    /**
     * @return HasOne<Board>
     */
    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    /**
     * Obtain all measurements related to this session.
     *
     * @return HasMany<Measurement>
     */
    public function measurements(): HasMany
    {
        return $this->hasMany(Measurement::class);
    }
}
