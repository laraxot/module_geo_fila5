<?php

namespace Modules\Ptv\Database\Factories;

/** @extends \\Illuminate\\Database\\Eloquent\\Factories\Factory<Modules\\Ptv\\Models\\User> */
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Ptv\Models\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     */
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [];
    }
}
