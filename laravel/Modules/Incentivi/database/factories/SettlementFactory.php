<?php

declare(strict_types=1);

namespace Modules\Incentivi\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Incentivi\Models\Settlement;

class SettlementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Settlement::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
