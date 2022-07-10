<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewCategoryTest extends TestCase
{
    use DatabaseMigrations;
    use WithFaker;

    /** @test */
    public function it_only_allows_only_authenticated_users()
    {
        $this->signOut()
            ->get(route('categories.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function it_only_displays_transaction_that_belongs_to_the_current_logged_in_user()
    {
        $category = Category::factory()->create(['user_id' => $this->user]);
        $otherCategory = Category::factory()->create();

        $this->get(route('categories.index'))
            ->assertSee($category->name)
            ->assertDontSee($otherCategory->name);
    }

    /** @test */
    public function it_can_display_all_categories()
    {
        $category = Category::factory()->create(['user_id' => $this->user]);

        $this->get(route('categories.index'))
            ->assertSee($category->name);
    }
}
