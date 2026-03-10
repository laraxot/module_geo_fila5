<?php

namespace Modules\IndennitaCondizioniLavoro\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriaProproFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\IndennitaCondizioniLavoro\Models\CategoriaPropro::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

