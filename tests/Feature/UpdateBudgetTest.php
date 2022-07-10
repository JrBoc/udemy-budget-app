<?php

namespace Tests\Feature;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateBudgetTest extends TestCase
{
    use WithFaker;
    use DatabaseMigrations;

    /** @test */
    public function it_can_update_budget()
    {
        $budget = Budget::factory()
            ->for(Category::factory()->state($user = ['user_id' => $this->user]))
            ->create($user);

        $newBudget = Budget::factory()->make($user);

        $response = $this->put(route('budgets.update', $budget), $newBudget->toArray())
            ->assertRedirect(route('budgets.index'));

        $this->followRedirects($response)
            ->assertSeeText($newBudget->amount);
    }

    /** @test */
    public function it_cannot_update_budget_without_a_amount()
    {
        $budget = Budget::factory()
            ->for(Category::factory()->state($user = ['user_id' => $this->user]))
            ->create($user);

        $this->putBudget($budget, ['amount' => null])
            ->assertSessionHasErrors('amount');
    }

    /** @test */
    public function it_cannot_update_budget_without_a_category_id()
    {
        $budget = Budget::factory()
            ->for(Category::factory()->state($user = ['user_id' => $this->user]))
            ->create($user);

        $this->putBudget($budget, ['category_id' => null])
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function it_cannot_update_budget_without_a_budget_date()
    {
        $budget = Budget::factory()
            ->for(Category::factory()->state($user = ['user_id' => $this->user]))
            ->create($user);

        $this->putBudget($budget, ['budget_date' => null])
            ->assertSessionHasErrors('budget_date');
    }

    /** @test */
    public function it_cannot_update_budget_with_an_invalid_budget_date()
    {
        $budget = Budget::factory()
            ->for(Category::factory()->state($user = ['user_id' => $this->user]))
            ->create($user);

        $this->putBudget($budget, ['budget_date' => 'abc'])
            ->assertSessionHasErrors('budget_date');
    }

    private function putBudget($budget, $newBudget = []): \Illuminate\Testing\TestResponse
    {
        return $this->put(route('budgets.update', $budget), $newBudget);
    }
}
