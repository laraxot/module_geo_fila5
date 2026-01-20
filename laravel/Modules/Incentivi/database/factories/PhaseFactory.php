<?php

declare(strict_types=1);

namespace Modules\Incentivi\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Incentivi\Models\Phase;

class PhaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Phase::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
