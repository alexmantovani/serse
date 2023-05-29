<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Translation>
 */
class TranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $languages = ['en', 'fr', 'es', 'pt'];
        return [
            'serial_number' => fake()->sentence(),
            'language' => $languages[rand(0,3)],
            'source' => fake()->sentence(),
        ];

    }
}
