<?php

namespace Modules\Sigma\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProvinceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Sigma\Models\Province::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

