<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Domain;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DomainFactory extends Factory
{
    protected $model = Domain::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'domain' => $this->faker->domainName(),
            'route' => $this->faker->domainWord(),
            'port' => $this->faker->numberBetween(1000, 65535),
            'is_secure' => $this->faker->boolean(),
            'is_letsencrypt' => $this->faker->boolean(),
            'renew_at' => $this->faker->boolean()
                ? Carbon::now()
                : null,
        ];
    }
}
