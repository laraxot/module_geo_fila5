<?php

declare(strict_types=1);

namespace Modules\Badge\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Badge\Models\Timbra;

class TimbraFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Timbra::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
