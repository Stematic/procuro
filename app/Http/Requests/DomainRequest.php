<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Domain;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @mixin Domain
 */
class DomainRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'server_id' => 'required|numeric|exists:servers,id',
            'domain' => [
                'required',
                'string',
                'max:255',
                Rule::unique('domains', 'domain')->ignore($this->domain),
            ],
            'route' => 'required|string|max:255',
            'port' => 'sometimes|numeric|max:65535',
            'is_secure' => 'sometimes|boolean',
            'is_letsencrypt' => 'sometimes|boolean',
        ];
    }
}
