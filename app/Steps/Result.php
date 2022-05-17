<?php

declare(strict_types=1);

namespace App\Steps;

use Closure;
use App\Services\ServerConfigResult;

class Result extends Server
{
    final public function handle(ServerConfigResult $result, Closure $next): string
    {
        return $this->generator->generate([... $result->data(), ... $this->map($result->server())]);
    }

    /**
     * The name of the stub file to use when generating.
     */
    public function stub(): string
    {
        return 'haproxy.conf.stub';
    }
}
