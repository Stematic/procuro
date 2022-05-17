<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Server;

interface ServerConfigBuilder
{
    /**
     * Creates a new builder instance.
     */
    public static function make(Server $server): static;

    /**
     * Builds the proxy configuration file, returning the contents.
     */
    public function build(): string;

    /**
     * Publishes the proxy configuration file on the server.
     */
    public function publish(): bool;
}
