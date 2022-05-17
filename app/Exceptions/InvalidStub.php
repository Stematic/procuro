<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

use function sprintf;

final class InvalidStub extends Exception
{
    /**
     * Creates a new exception from the provided file path.
     */
    public static function make(string $path): self
    {
        return new self(sprintf('Stub file "%s" does not exist!', $path));
    }
}
