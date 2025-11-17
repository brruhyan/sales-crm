<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Leads>
 */
class LeadsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lead_title' => fake()->catchPhrase(),
            'lead_type' => fake()->randomElement(['Qualified', 'Unqualified', 'New']),
            'product' => json_encode([fake()->word(), fake()->word()]),
            'name' => fake()->name(),
            'email' => fake()->unique()->companyEmail(),
            'phone' => fake()->phoneNumber(),
            'company' => fake()->company(),
            'source' => fake()->randomElement(['Website', 'Email', 'Phone', 'Social Media', 'Referral']),
            'status' => fake()->randomElement(['New', 'For Review', 'Qualified', 'Lost']),
        ];
    }
}
