<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ServerRequest;
use App\Http\Resources\ServerResource;
use App\Models\Server;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class ServersController extends Controller
{
    /**
     * Returns a list of server records.
     */
    public function index(Request $request): JsonResponse
    {
        $records = Server::query()->paginate(... $this->getPageNumbers($request));

        return $this->respondWithPaginatedResourceCollection($records, ServerResource::class);
    }

    /**
     * Creates a new server record.
     */
    public function store(ServerRequest $request): JsonResponse
    {
        $record = Server::query()->create($request->validated());

        return $this->respondWithSuccess(ServerResource::make($record));
    }

    /**
     * Retrieves an existing server record.
     */
    public function show(Server $server): JsonResponse
    {
        return $this->respondWithSuccess(ServerResource::make($server));
    }

    /**
     * Updates an existing server record.
     */
    public function update(ServerRequest $request, Server $server): JsonResponse
    {
        $server->update($request->validated());

        return $this->respondOk(__('resource.updated'));
    }

    /**
     * Destroys an existing server record.
     *
     * @throws Throwable
     */
    public function destroy(Server $server): JsonResponse
    {
        $server->deleteOrFail();

        return $this->respondOk(__('resource.deleted'));
    }
}
