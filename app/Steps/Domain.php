<?php

declare(strict_types=1);

namespace App\Steps;

use Closure;
use App\Models\Domain as DomainModel;
use App\Services\ServerConfigResult;

use function assert;

abstract class Domain extends Step
{
    /**
     * Runs the pipeline step to generate the configuration part.
     */
    public function handle(ServerConfigResult $result, Closure $next): mixed
    {
        $items = $result->server()->domains->map(function (DomainModel $domain) use ($result) {
            return $this->generator->generate([... $result->data(), ... $this->map($domain)]);
        });

        $result->push($this->key(), $items->implode("\n"));

        return $next($result);
    }

    /**
     * Returns an array of variables / template replacements which are provided to the stub.
     *
     * @return array<string, mixed>
     */
    public function map(mixed $item): array
    {
        assert($item instanceof DomainModel);

        return [
            'id' => $item->id,
            'name' => $item->domain,
            'route' => $item->route,
            'backend' => $item->backend,
            'port' => $item->port,
        ];
    }
}
