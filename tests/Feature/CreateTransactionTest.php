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
        $transaction = Transaction::factory()->make();

        $response = $this->post(route('transactions.store'), $transaction->toArray());

        $response->assertRedirect(route('transactions.index'));

        $this->followRedirects($response)->assertSee($transaction->description);
    }

    /** @test */
    public function it_cannot_create_transactions_without_a_description()
    {
        $response = $this->postTransaction([
            'description' => null,
        ]);

        $response->assertSessionHasErrors('description');
    }

    /** @test */
    public function it_cannot_create_transactions_without_a_category_id()
    {
        $response = $this->postTransaction([
            'category_id' => null,
        ]);

        $response->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function it_cannot_create_transactions_without_an_amount()
    {
        $response = $this->postTransaction([
            'amount' => null,
        ]);

        $response->assertSessionHasErrors('amount');
    }

    /** @test */
    public function it_cannot_create_transactions_without_a_valid_amount()
    {
        $response = $this->postTransaction([
            'amount' => 'abc',
        ]);

        $response->assertSessionHasErrors('amount');
    }

    private function postTransaction($overwrites = []): \Illuminate\Testing\TestResponse
    {
        $transaction = Transaction::factory()->make($overwrites);

        return $this->post(route('transactions.store'), $transaction->toArray());
    }

}
