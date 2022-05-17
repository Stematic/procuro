<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\ServerConfigBuilder as ServerConfigBuilderContract;
use App\Models\Server;
use App\Steps\Acl;
use App\Steps\Backend;
use App\Steps\Defaults;
use App\Steps\Frontend;
use App\Steps\General;
use App\Steps\Result;
use Illuminate\Pipeline\Pipeline;

class ServerConfigBuilder implements ServerConfigBuilderContract
{
    protected array $pipes = [
        Acl::class,
        Backend::class,
        Defaults::class,
        Frontend::class,
        General::class,
        Result::class,
    ];

    protected function __construct(protected Server $server)
    {}

    public static function make(Server $server): static
    {
        return new static($server);
    }

    public function build(): string
    {
        $result = resolve(ServerConfigResult::class, ['server' => $this->server]);

        return resolve(Pipeline::class)
            ->send($result)
            ->through($this->pipes)
            ->thenReturn();
    }

    public function publish(): bool
    {
        // TODO: Implement publish() method.
    }
}
