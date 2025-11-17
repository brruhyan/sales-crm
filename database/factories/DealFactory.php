<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deal>
 */
class DealFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->catchPhrase(),
            'description' => fake()->paragraph(),
            'amount' => fake()->numberBetween(10000, 500000),
            'currency' => 'USD',
            'probability' => fake()->numberBetween(10, 100),
            'status' => fake()->randomElement(['Prospecting', 'Qualification', 'Needs Analysis', 'Value Proposition', 'For Review', 'Deal Won', 'Closed Won', 'Closed Lost']),
            'source' => fake()->randomElement(['Website', 'Email', 'Phone', 'Social Media', 'Referral']),
            'expected_close_date' => fake()->dateTimeBetween('now', '+6 months'),
            'actual_close_date' => null,
        ];
    }
}
