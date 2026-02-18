<?php

namespace Modules\Sigma\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WebServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Sigma\Models\WebService::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
