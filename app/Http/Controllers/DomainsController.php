<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\DomainRequest;
use App\Http\Resources\DomainResource;
use App\Models\Domain;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class DomainsController extends Controller
{
    /**
     * Returns a list of domain records.
     */
    public function index(Request $request): JsonResponse
    {
        $records = Domain::query()->paginate(... $this->getPageNumbers($request));

        return $this->respondWithPaginatedResourceCollection($records, DomainResource::class);
    }

    /**
     * Creates a new domain record.
     */
    public function store(DomainRequest $request): JsonResponse
    {
        $record = Domain::query()->create($request->validated());

        return $this->respondWithSuccess(DomainResource::make($record));
    }

    /**
     * Retrieves an existing domain record.
     */
    public function show(Domain $domain): JsonResponse
    {
        return $this->respondWithSuccess(DomainResource::make($domain));
    }

    /**
     * Updates an existing domain record.
     */
    public function update(DomainRequest $request, Domain $domain): JsonResponse
    {
        $domain->update($request->validated());

        return $this->respondOk(__('resource.updated'));
    }

    /**
     * Destroys an existing domain record.
     *
     * @throws Throwable
     */
    public function destroy(Domain $domain): JsonResponse
    {
        $domain->deleteOrFail();

        return $this->respondOk(__('resource.deleted'));
    }
}
