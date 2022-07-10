<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BudgetFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory()->create(),
            'user_id' => User::factory()->create(),
            'amount' => $this->faker->randomFloat(2, 500, 1000),
            'budget_date' => now()->format('M'),
        ];
    }
}
