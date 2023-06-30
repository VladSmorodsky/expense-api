<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 1, 100),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'created_at' => fake()->dateTimeBetween('-5 months', 'now')
        ];
    }
}
