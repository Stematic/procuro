<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property-read int $id
 * @property-read string $backend
 *
 * @property string $domain
 * @property string $route
 * @property int $port
 * @property bool $is_secure
 * @property bool $is_letsencrypt
 * @property ?Carbon $renew_at
 * @property Carbon $created_at
 * @property ?Carbon $updated_at
 */
class Domain extends Model
{
    use HasFactory;

    /**
     * The model attributes for mass assignment.
     *
     * @var string[]
     */
    protected $fillable = [
        'server_id',
        'domain',
        'route',
        'port',
        'is_secure',
        'is_letsencrypt',
        'renew_at',
    ];

    /**
     * Returns the name of the server to use as the HAProxy backend.
     */
    public function getBackendAttribute(): string
    {
        $path = Str::replace('.', ' ', Str::lower($this->domain));

        return Str::slug($path, '_');
    }

    /**
     * A domain belongs to a server.
     */
    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }
}
