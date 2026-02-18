<?php

namespace Modules\Sigma\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TableListFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Sigma\Models\TableList::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

