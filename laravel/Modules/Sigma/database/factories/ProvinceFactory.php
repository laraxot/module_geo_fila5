<?php

namespace Modules\Sigma\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Sigma\Models\Province;

class ProvinceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Province::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
