<?php

namespace Modules\Sigma\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Sigma\Models\Acptv;

class AcptvFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Acptv::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
