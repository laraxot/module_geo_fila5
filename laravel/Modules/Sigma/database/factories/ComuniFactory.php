<?php

namespace Modules\Sigma\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Sigma\Models\Comuni;

class ComuniFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Comuni::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
