<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use F9Web\ApiResponseHelpers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;

use function assert;
use function is_subclass_of;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
    use ApiResponseHelpers;

    /**
     * Returns the current page numbers from the request.
     *
     * @return int[]
     */
    protected function getPageNumbers(Request $request): array
    {
        return [
            'page' => (int) $request->get('page', 1),
            'perPage' => (int) $request->get('size', 25),
        ];
    }

    /**
     * Responds with a paginated resource collection based on the given records.
     */
    protected function respondWithPaginatedResourceCollection(
        LengthAwarePaginator $records,
        string $resource,
    ): JsonResponse
    {
        assert(is_subclass_of($resource, JsonResource::class));

        return $resource::collection($records)->toResponse(request());
    }
}
