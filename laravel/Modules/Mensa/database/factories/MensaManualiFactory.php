<?php

declare(strict_types=1);

namespace Modules\Mensa\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Mensa\Models\MensaManuali;

class MensaManualiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = MensaManuali::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
