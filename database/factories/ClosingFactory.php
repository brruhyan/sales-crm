<?php

namespace Database\Factories;

use App\Models\Closing;
use App\Models\Deal;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Closing>
 */
class ClosingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'deal_id' => Deal::factory(),
            'contact_id' => Contact::factory(),
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['Open', 'In Progress', 'Pending Documentation', 'Closed Won', 'Closed Lost']),
            'expected_close_date' => $this->faker->dateTimeBetween('now', '+3 months'),
            'actual_close_date' => null,
            'amount' => $this->faker->randomFloat(2, 10000, 100000),
            'currency' => 'USD',
            'probability' => $this->faker->numberBetween(0, 100),
            'documents' => null,
            'notes' => $this->faker->paragraph(),
        ];
    }
}
