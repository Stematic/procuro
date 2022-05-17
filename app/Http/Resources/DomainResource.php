<?php

namespace App\Http\Resources;

use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Domain
 */
class DomainResource extends JsonResource
{
    /**
     * Returns domain details as an array.
     *
     * @param Request $request
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'domain' => $this->domain,
            'route' => $this->route,
            'port' => $this->port,
            'backend' => $this->backend,
            'is_secure' => $this->is_secure,
            'is_letsencrypt' => $this->is_letsencrypt,
            'renew_at' => $this->renew_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
