<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Profile
 *
 * @property int $id
 * @property string $name
 * @property int $soak_temperature
 * @property int $soak_time
 * @property int $reflow_gradient
 * @property int $ramp_up_gradient
 * @property int $reflow_peak_temp
 * @property int $reflow_max_time
 * @property int $cooldown_gradient
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|Profile newModelQuery()
 * @method static Builder|Profile newQuery()
 * @method static Builder|Profile query()
 * @method static Builder|Profile whereCooldownGradient($value)
 * @method static Builder|Profile whereCreatedAt($value)
 * @method static Builder|Profile whereId($value)
 * @method static Builder|Profile whereName($value)
 * @method static Builder|Profile whereRampUpGradient($value)
 * @method static Builder|Profile whereReflowGradient($value)
 * @method static Builder|Profile whereReflowMaxTime($value)
 * @method static Builder|Profile whereReflowPeakTemp($value)
 * @method static Builder|Profile whereSoakTemperature($value)
 * @method static Builder|Profile whereSoakTime($value)
 * @method static Builder|Profile whereUpdatedAt($value)
 *
 * @mixin Builder<Profile>
 */
class Profile extends Model
{
    use HasFactory;
}
