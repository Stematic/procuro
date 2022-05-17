<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property-read bool $exists
 *
 * @property string $name
 * @property string $hostname
 * @property string $config_path
 * @property bool $show_stats
 * @property ?string $stats_uri
 * @property ?string $stats_user
 * @property ?string $stats_password
 * @property ?string $extra_defaults
 * @property ?string $extra_globals
 * @property Carbon $created_at
 * @property ?Carbon $updated_at
 * @property Collection $domains
 */
class Server extends Model
{
    use HasFactory;

    /**
     * The model attributes for mass assignment.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'hostname',
        'config_path',
        'show_stats',
        'stats_uri',
        'stats_user',
        'stats_password',
        'extra_defaults',
        'extra_globals',
    ];

    /**
     * A server has many domains.
     */
    public function domains(): HasMany
    {
        return $this->hasMany(Domain::class);
    }
}
