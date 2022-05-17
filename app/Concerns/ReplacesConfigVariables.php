<?php

declare(strict_types=1);

namespace App\Concerns;

trait ReplacesConfigVariables
{
    /**
     * Evaluates conditionals based on setting values.
     * If the setting evaluates to true, the inner content is retained
     * else, the inner content is discarded (setting off).
     */
    protected function replaceConditionals(string $contents, array $data): string
    {
        return preg_replace_callback(
            '/{{#((?:[^}]|}[^}])+)}}([\S\s](?:[^{]|[^{]+.*)+)*?{{\/(?:[^}]|}[^}])+}}/',
            function ($match) use ($data) {
                [, $key, $contents] = $match;

                return $this->validateCondition($key, $data)
                    ? $contents
                    : '';
            },
            $contents
        );
    }

    /**
     * Validates a given key as a conditional.
     */
    protected function validateCondition(string $key, array $data): bool
    {
        return isset($data[$key])
            ? filter_var($data[$key], FILTER_VALIDATE_BOOL)
            : false;
    }

    /**
     * Replaces variables within the configuration stub file with the values from settings.
     */
    protected function replaceVariables(string $contents, array $data): string
    {
        return preg_replace_callback(
            '/{{((?:[^}]|}[^}])+)}}/',
            static function ($match) use ($data): string {
                [$original, $key] = $match;

                return array_key_exists($key, $data)
                    ? (string) $data[$key]
                    : $original;
            },
            $contents
        );
    }
}
