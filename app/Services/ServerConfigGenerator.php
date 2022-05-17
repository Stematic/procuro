<?php

declare(strict_types=1);

namespace App\Services;

use App\Concerns\ReplacesConfigVariables;
use App\Concerns\RetrievesStubFiles;
use App\Exceptions\InvalidStub;
use Illuminate\Support\Carbon;

use function preg_replace;

class ServerConfigGenerator
{
    use ReplacesConfigVariables;
    use RetrievesStubFiles;

    public function __construct(protected string $file)
    {
    }

    /**
     * Generates an evaluated stub file.
     *
     * @param array<string, mixed> $data
     *
     * @throws InvalidStub
     */
    public function generate(array $data): string
    {
        $data['generation-time'] = Carbon::now()->toIso8601ZuluString();

        // Replace conditional blocks and variables with our setting values.
        $content = $this->replaceVariables(
            $this->replaceConditionals($this->file(), $data),
            $data,
        );

        // Remove empty lines from the output file.
        return preg_replace('/^(\h*\v){2,}+/m', "\n", $content);
    }
}
