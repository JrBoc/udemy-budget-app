<?php

namespace Tests\Feature;

use App\Models\Transaction;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateTransactionTest extends TestCase
{
    use WithFaker;
    use DatabaseMigrations;

    /** @test */
    public function it_can_update_transaction()
    {
        $transaction = Transaction::factory(['user_id' => $this->user])->create();
        $newTransaction = Transaction::factory(['user_id' => $this->user])->make();

        $response = $this->put(route('transactions.update', $transaction), $newTransaction->toArray())
            ->assertRedirect(route('transactions.index'));

        $this->followRedirects($response)
            ->assertSee($newTransaction->description);
    }

    /** @test */
    public function it_cannot_update_transactions_without_a_description()
    {
        $transaction = Transaction::factory(['user_id' => $this->user])->create();

        $this->putTransaction($transaction, ['description' => null])
            ->assertSessionHasErrors('description');
    }

    /** @test */
    public function it_cannot_update_transactions_without_a_category_id()
    {
        $transaction = Transaction::factory(['user_id' => $this->user])->create();

        $this->putTransaction($transaction, ['category_id' => null])
            ->assertSessionHasErrors('description');
    }

    /** @test */
    public function it_cannot_update_transactions_without_an_amount()
    {
        $transaction = Transaction::factory(['user_id' => $this->user])->create();

        $this->putTransaction($transaction, ['amount' => null])
            ->assertSessionHasErrors('description');
    }

    /** @test */
    public function it_cannot_update_transactions_without_a_valid_amount()
    {
        $transaction = Transaction::factory(['user_id' => $this->user])->create();

        $this->putTransaction($transaction, ['amount' => 'abc'])
            ->assertSessionHasErrors('amount');
    }

    private function putTransaction($transaction, $newTransaction = []): \Illuminate\Testing\TestResponse
    {
        return $this->put(route('transactions.update', $transaction), $newTransaction);
    }
}
