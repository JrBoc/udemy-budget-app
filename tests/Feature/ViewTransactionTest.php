<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTransactionTest extends TestCase
{
    use WithFaker;
    use DatabaseMigrations;

    /** @test */
    public function it_can_display_all_transactions()
    {
        $transaction = Transaction::factory()->create();

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
        ]);

        $otherTransaction = Transaction::factory()->create();

        $response = $this->get(route('transactions.index', $category->slug));

        $response
            ->assertSee($transaction->description)
            ->assertDontSee($otherTransaction->category->name);
    }
}
