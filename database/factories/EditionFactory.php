<?php

namespace Database\Factories;

use App\Language;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Edition>
 */
class EditionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text' => fake()->paragraph(),
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'language_id' => function () {
                return Language::factory()->create()->id;
            },
            'status' => 'accepted'
        ];
    }
}
