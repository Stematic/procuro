<?php

namespace App\Exceptions;

use Exception;

use function sprintf;

class InvalidStub extends Exception
{
    /**
     * Creates a new exception from the provided file path.
     */
    public static function make(string $path): static
    {
        return new static(sprintf('Stub file "%s" does not exist!', $path));
    }
}
