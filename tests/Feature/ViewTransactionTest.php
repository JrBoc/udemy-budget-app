<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTransactionTest extends TestCase
{
    use WithFaker;
    use DatabaseMigrations;

    /** @test */
    public function it_only_allows_only_authenticated_users()
    {
        $this->signOut()
            ->get(route('transactions.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function it_only_displays_transaction_that_belongs_to_the_current_logged_in_user()
    {
        $otherUser = User::factory()->create();
        $transaction = Transaction::factory()->create(['user_id' => $this->user]);
        $otherTransaction = Transaction::factory()->create(['user_id' => $otherUser]);

        $this->get(route('transactions.index'))
            ->assertSee($transaction->description)
            ->assertDontSee($otherTransaction->description);
    }

    /** @test */
    public function it_can_display_all_transactions()
    {
        $transaction = Transaction::factory()->create(['user_id' => $this->user]);

        $this->get(route('transactions.index'))
            ->assertSee($transaction->description)
            ->assertSee($transaction->category->name);
    }

    /** @test */
    public function it_can_filter_transactions_by_category()
    {
        $category = Category::factory()->create();
        $transaction = Transaction::factory()->create(['category_id' => $category, 'user_id' => $this->user]);
        $otherTransaction = Transaction::factory()->create(['user_id' => $this->user]);

        $this->get(route('transactions.index', $category->slug))
            ->assertSee($transaction->description)
            ->assertSeeText($otherTransaction->category->name);
    }

    /** @test */
    public function it_can_filter_transactions_by_month()
    {
        $currentTransaction = Transaction::factory()->create(['user_id' => $this->user]);
        $passTransaction = Transaction::factory()->create(['created_at' => now()->subMonths(2), 'user_id' => $this->user]);

        $this->get(route('transactions.index', ['month' => now()->subMonths(2)->format('M')]))
            ->assertSee($passTransaction->description)
            ->assertDontSee($currentTransaction->description);
    }

    /** @test */
    public function it_can_filter_transactions_by_current_month_by_default()
    {
        $currentTransaction = Transaction::factory()->create(['user_id' => $this->user]);
        $passTransaction = Transaction::factory()->create(['created_at' => now()->subMonths(2), 'user_id' => $this->user]);

        $this->get(route('transactions.index'))
            ->assertSee($currentTransaction->description)
            ->assertDontSee($passTransaction->description);
    }
}
