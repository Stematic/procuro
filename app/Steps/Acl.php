<?php

declare(strict_types=1);

namespace App\Steps;

class Acl extends Domain
{
    /**
     * The name of the stub file to use when generating.
     */
    public function stub(): string
    {
        return 'acl.stub';
    }
}
