<?php

declare(strict_types=1);

namespace Modules\Prenotazioni\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Prenotazioni\Models\CalendarioAppuntamenti;

class CalendarioAppuntamentiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = CalendarioAppuntamenti::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
