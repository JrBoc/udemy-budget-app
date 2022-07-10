<?php

namespace Tests\Feature;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateBudgetTest extends TestCase
{
    use WithFaker;
    use DatabaseMigrations;

    /** @test */
    public function it_can_create_budget()
    {
        $category = Category::factory()->create([
            'user_id' => $this->user,
        ]);

        $budget = Budget::factory()->make([
            'category_id' => $category,
            'user_id' => $this->user,
        ]);

        $response = $this->post(route('budgets.store'), $budget->toArray());

        $response->assertRedirect(route('budgets.index'));

        $this->followRedirects($response)->assertSeeText($budget->amount);
    }

    /** @test */
    public function it_cannot_create_budget_without_a_amount()
    {
        $this->postBudget(['amount' => null])
            ->assertSessionHasErrors('amount');
    }

    /** @test */
    public function it_cannot_create_budget_without_a_category_id()
    {
        $this->postBudget(['category_id' => null])
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function it_cannot_create_budget_without_a_budget_date()
    {
        $this->postBudget(['budget_date' => null])
            ->assertSessionHasErrors('budget_date');
    }

    private function postBudget($overwrites = []): \Illuminate\Testing\TestResponse
    {
        $budget = Budget::factory()
            ->for(Category::factory()->state(['user_id' => $this->user]))
            ->make($overwrites);

        return $this->post(route('budgets.store'), $budget->toArray());
    }
}
