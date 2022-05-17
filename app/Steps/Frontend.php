<?php

declare(strict_types=1);

namespace App\Steps;

class Frontend extends Server
{
    /**
     * The name of the stub file to use when generating.
     */
    public function stub(): string
    {
        return 'frontend.stub';
    }
}
