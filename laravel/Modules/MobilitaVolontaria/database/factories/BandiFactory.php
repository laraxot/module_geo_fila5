<?php

declare(strict_types=1);

namespace Modules\MobilitaVolontaria\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Modules\MobilitaVolontaria\Models\Bandi;

class BandiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = Bandi::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->randomNumber(),
            'comune' => $this->faker->word,
        ];
    }
}
