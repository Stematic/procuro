<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Server;

class ServerConfigResult
{
    /**
     * The variables passed into each pipe.
     *
     * @var array<string, mixed>
     */
    protected array $data;

    public function __construct(protected Server $server)
    {
        $this->data = [];
    }

    /**
     * Pushes the provided result into data with the given key.
     */
    public function push(string $key, string $result): void
    {
        $this->data[$key] = $result;
    }

    /**
     * Returns the server.
     */
    public function server(): Server
    {
        return $this->server;
    }

    /**
     * The currently mapped data.
     *
     * @return array<string, mixed>
     */
    public function data(): array
    {
        return $this->data;
    }
}
