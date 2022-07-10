<?php

namespace Tests\Feature;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewBudgetTest extends TestCase
{
    use WithFaker;
    use DatabaseMigrations;

    /** @test */
    public function it_only_allows_only_authenticated_users()
    {
        $this->signOut()
            ->get(route('budgets.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function it_only_displays_transaction_that_belongs_to_the_current_logged_in_user()
    {
        $budget = Budget::factory()
            ->for(Category::factory()->state($user = ['user_id' => $this->user]))
            ->create($user);

        $otherBudget = Budget::factory()
            ->for(Category::factory())
            ->create();

        $this->get(route('budgets.index'))
            ->assertSee($budget->amount)
            ->assertSee($budget->balance())
            ->assertSee($otherBudget->amount)
            ->assertSee($otherBudget->balance());
    }

    /** @test */
    public function it_should_display_budget_for_the_current_month_by_default()
    {
        $budgetForThisMonth = Budget::factory()
            ->for(Category::factory()->state($user = ['user_id' => $this->user]))
            ->create($user);
        $budgetForLastMonth = Budget::factory()
            ->for(Category::factory()->state($user))
            ->create(array_merge($user, ['created_at' => now()->subMonth()]));

        $this->get(route('budgets.index'))
            ->assertSee($budgetForThisMonth->amount)
            ->assertSee($budgetForThisMonth->balance())
            ->assertSee($budgetForLastMonth->amount)
            ->assertSee($budgetForLastMonth->balance());
    }
}
