<?php

namespace Tests\Unit;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BudgetTest extends TestCase
{
    use WithFaker;
    use DatabaseMigrations;

    /** @test */
    public function it_has_balance()
    {
        $category = Category::factory()->create();
        $transaction = Transaction::factory(3)->create($userAndCategory = ['user_id' => $category->user_id, 'category_id' => $category]);
        $budget = Budget::factory()->create($userAndCategory);

        $expectedBalance = $budget->amount = $transaction->sum('amount');

        $this->assertEquals($expectedBalance, $budget->balance());
    }
}
