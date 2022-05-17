<?php

declare(strict_types=1);

namespace App\Contracts;

use Closure;
use App\Services\ServerConfigResult;

interface Step
{
    /**
     * Runs the pipeline step to generate the configuration part.
     */
    public function handle(ServerConfigResult $result, Closure $next): mixed;

    /**
     * The name of the stub file to use when generating.
     */
    public function stub(): string;
}
