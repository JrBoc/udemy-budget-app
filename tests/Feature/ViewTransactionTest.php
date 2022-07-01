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
        $response = $this
            ->signOut()
            ->get(route('transactions.index'));

        $response->assertRedirect(route('login'));
    }


    /** @test */
    public function it_only_displays_transaction_that_belongs_to_the_current_logged_in_user()
    {
        $otherUser = User::factory()->create();

        $transaction = Transaction::factory()->create([
            'user_id' => $this->user->id,
        ]);
        $otherTransaction = Transaction::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $response = $this->get(route('transactions.index'));

        $response
            ->assertSee($transaction->description)
            ->assertDontSee($otherTransaction->description);
    }

    /** @test */
    public function it_can_display_all_transactions()
    {
        $transaction = Transaction::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->get(route('transactions.index'));

        $response
            ->assertSee($transaction->description)
            ->assertSee($transaction->category->name);
    }

    /** @test */
    public function it_can_filter_transactions_by_category()
    {
        $category = Category::factory()->create();
        $transaction = Transaction::factory()->create([
            'category_id' => $category->id,
            'user_id' => $this->user->id,
        ]);

        $otherTransaction = Transaction::factory()->create();

        $response = $this->get(route('transactions.index', $category->slug));

        $response
            ->assertSee($transaction->description)
            ->assertDontSee($otherTransaction->category->name);
    }
}
