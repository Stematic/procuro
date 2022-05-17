<?php

declare(strict_types=1);

namespace App\Steps;

use App\Services\ServerConfigGenerator;
use App\Contracts\Step as StepContract;
use Illuminate\Support\Str;

abstract class Step implements StepContract
{
    public ServerConfigGenerator $generator;

    public function __construct()
    {
        $this->generator = resolve(ServerConfigGenerator::class, [
            'file' => $this->stub(),
        ]);
    }

    /**
     * Returns the key to use (allows files to be included within other files in future steps).
     */
    protected function key(): string
    {
        return Str::plural(Str::slug(class_basename(static::class), '_'));
    }
}
