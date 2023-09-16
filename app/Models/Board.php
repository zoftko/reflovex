<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Board
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string|null $ip
 * @property string|null $last_seen
 * @property bool $working
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|Board newModelQuery()
 * @method static Builder|Board newQuery()
 * @method static Builder|Board query()
 * @method static Builder|Board whereCreatedAt($value)
 * @method static Builder|Board whereId($value)
 * @method static Builder|Board whereIp($value)
 * @method static Builder|Board whereLastSeen($value)
 * @method static Builder|Board whereName($value)
 * @method static Builder|Board whereUpdatedAt($value)
 * @method static Builder|Board whereUuid($value)
 * @method static Builder|Board whereWorking($value)
 *
 * @mixin Builder<Board>
 */
class Board extends Model
{
    use HasFactory;
}
