<?php

namespace Tests\Feature;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteBudgetTest extends TestCase
{
    use WithFaker;
    use DatabaseMigrations;

    /** @test */
    public function it_can_delete_budget()
    {
        $budget = Budget::factory()
            ->for(Category::factory()->state($user = ['user_id' => $this->user]))
            ->create($user);

        $response = $this->delete(route('budgets.destroy', $budget))
            ->assertRedirect(route('budgets.index'));

        $this->followRedirects($response)
            ->assertDontSee($budget->amount);
    }
}
