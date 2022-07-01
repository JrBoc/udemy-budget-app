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
        $category = Category::factory()->create();
        $transaction = Transaction::factory()->make([
            'category_id' => $category->id,
        ]);

        $response = $this->post(route('transactions.store'), $transaction->toArray());

        $response->assertRedirect(route('transactions.index'));

        $this->followRedirects($response)->assertSee($transaction->description);
    }
}
