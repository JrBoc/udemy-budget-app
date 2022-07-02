<?php

namespace Tests\Feature;

use App\Models\Transaction;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteTransactionTest extends TestCase
{
    use WithFaker;
    use DatabaseMigrations;

    /** @test */
    public function it_can_delete_transactions()
    {
        $transaction = Transaction::factory()->create(['user_id' => $this->user->id]);

        $response = $this->delete(route('transactions.destroy', $transaction))
            ->assertRedirect(route('transactions.index'));

        $this->followRedirects($response)
            ->assertDontSee($transaction->description);
    }
}
