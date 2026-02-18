<?php

namespace Modules\Performance\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class IndividualePoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Performance\Models\IndividualePo::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

