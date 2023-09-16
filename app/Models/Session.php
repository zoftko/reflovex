<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'board_id',
        'soak_temperature',
        'soak_time',
        'reflow_gradient',
        'reflow_max_time',
        'reflow_peak_temp',
        'ramp_up_gradient',
        'cooldown_gradient',
        'date'
    ];

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
