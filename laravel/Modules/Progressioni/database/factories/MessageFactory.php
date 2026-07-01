<?php

namespace Modules\Progressioni\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Progressioni\Models\Message;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
