<?php

declare(strict_types=1);

namespace App\Steps;

use Closure;
use App\Models\Server as ServerModel;
use App\Services\ServerConfigResult;

use function assert;

abstract class Server extends Step
{
    /**
     * Runs the pipeline step to generate the configuration part.
     */
    public function handle(ServerConfigResult $result, Closure $next): mixed
    {
        $data = $this->generator->generate([... $result->data(), ... $this->map($result->server())]);

        $result->push($this->key(), $data);

        return $next($result);
    }

    /**
     * Returns an array of variables / template replacements which are provided to the stub.
     *
     * @return array<string, mixed>
     */
    public function map(mixed $item): array
    {
        assert($item instanceof ServerModel);

        return [
            'id' => $item->id,
            'name' => $item->name,
            'hostname' => $item->hostname,
            'config_path' => $item->config_path,
            'stats' => $item->show_stats,
            'stats_uri' => $item->stats_uri,
            'stats_password' => $item->stats_password,
            'extra_defaults' => $item->extra_defaults,
            'extra_globals' => $item->extra_globals,
        ];
    }
}
