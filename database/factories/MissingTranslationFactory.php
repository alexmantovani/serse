<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MissingTranslation>
 */
class MissingTranslationFactory extends Factory
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
