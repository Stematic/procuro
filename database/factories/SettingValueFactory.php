<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Setting;
use App\Models\SettingValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingValueFactory extends Factory
{
    protected $model = SettingValue::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'value' => $this->faker->sentence(),
        ];
    }
}
