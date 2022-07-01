<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'description' => $this->faker->sentence(2),
            'category_id' => Category::factory()->create(),
            'amount' => $this->faker->randomFloat(),
            'user_id' => User::factory()->create(),
        ];
    }
}
