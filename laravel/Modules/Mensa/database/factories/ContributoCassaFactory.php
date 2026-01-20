<?php

declare(strict_types=1);

namespace Modules\Mensa\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Mensa\Models\ContributoCassa;

class ContributoCassaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = ContributoCassa::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
