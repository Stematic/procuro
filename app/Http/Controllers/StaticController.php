<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;

use function sprintf;

class StaticController extends Controller
{
    use ApiResponseHelpers;

    /**
     * Returns the application information.
     */
    public function main(): JsonResponse
    {
//        $server = Server::query()->first();
//
//        assert($server instanceof Server);
//
//        $builder = ServerConfigBuilder::make($server);
//
//        echo "<pre>" . $builder->build() . "</pre>";
//        exit;

        return $this->respondWithSuccess([
            'application' => 'Procuro',
            'version' => sprintf('%s (Laravel %s)', config('app.version'), app()->version()),
        ]);
    }
}
