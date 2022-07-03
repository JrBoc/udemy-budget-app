<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTransactionTest extends TestCase
{
    use WithFaker;
    use DatabaseMigrations;

    /** @test */
    public function it_can_create_transaction()
    {
        $transaction = Transaction::factory()
            ->for(Category::factory()->state(['user_id' => $this->user]))
            ->make([
                'user_id' => $this->user,
            ]);

        $response = $this->post(route('transactions.store'), $transaction->toArray())
            ->assertRedirect(route('transactions.index'));

        $this->followRedirects($response)->assertSee($transaction->description);
    }

    /** @test */
    public function it_cannot_create_transactions_without_a_description()
    {
        $this->postTransaction(['description' => null])
            ->assertSessionHasErrors('description');
    }

    /** @test */
    public function it_cannot_create_transactions_without_a_category_id()
    {
        $this->postTransaction(['category_id' => null])
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function it_cannot_create_transactions_without_an_amount()
    {
        $this->postTransaction(['amount' => null])
            ->assertSessionHasErrors('amount');
    }

    /** @test */
    public function it_cannot_create_transactions_without_a_valid_amount()
    {
        $this->postTransaction(['amount' => 'abc'])
            ->assertSessionHasErrors('amount');
    }

    private function postTransaction($overwrites = []): \Illuminate\Testing\TestResponse
    {
        $transaction = Transaction::factory()
            ->for(Category::factory()->state(['user_id' => $this->user]))
            ->make($overwrites);

        return $this->post(route('transactions.store'), $transaction->toArray());
    }
}
