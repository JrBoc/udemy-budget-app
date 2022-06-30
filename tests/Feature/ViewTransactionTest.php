<?php

namespace Tests\Feature;

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

        $response->assertSee($transaction->description);
    }
}
