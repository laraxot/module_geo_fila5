<?php

declare(strict_types=1);

namespace Modules\Ptv\Database\Factories;

/** @extends \\Illuminate\\Database\\Eloquent\\Factories\Factory<Modules\\Ptv\\Models\\Message> */
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Ptv\Models\Message;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Message::class;

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
