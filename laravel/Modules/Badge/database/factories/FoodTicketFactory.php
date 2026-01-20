<?php

declare(strict_types=1);

namespace Modules\Badge\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Badge\Models\FoodTicket;

class FoodTicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = FoodTicket::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
