<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Exceptions\InvalidStub;

use function file_exists;
use function file_get_contents;
use function assert;
use function is_string;
use function sprintf;

trait RetrievesStubFiles
{
    /**
     * Returns the stub file for the generator.
     *
     * @throws InvalidStub
     */
    protected function file(): string
    {
        $path = $this->getStubPath();

        if (! file_exists($path)) {
            throw InvalidStub::make($path);
        }

        $contents = file_get_contents($path);

        assert(is_string($contents));

        return $contents;
    }

    /**
     * Returns the qualified path from the resource directory for the stub.
     */
    protected function getStubPath(): string
    {
        return resource_path(sprintf('stubs/%s', $this->file));
    }
}
