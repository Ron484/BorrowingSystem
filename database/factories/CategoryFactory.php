<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Str;
use Laravel\Jetstream\Features;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement([
                'Romance',
                'Science Fiction',
                'Fantasy',
                'History',
                'Science',
                'Technology',
                'Art',
                'Philosophy',
                'Poetry',
                'Drama',
                'Health',
                'Cooking',
            ]),
        ];
    }
}