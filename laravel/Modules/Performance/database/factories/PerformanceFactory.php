<?php

namespace Modules\Performance\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PerformanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Performance\Models\Performance::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

