<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Transaction;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteCategoryTest extends TestCase
{
    use WithFaker;
    use DatabaseMigrations;

    /** @test */
    public function it_can_delete_category()
    {
        $category = Category::factory()->create(['user_id' => $this->user]);

        $transaction = Transaction::factory()->create([
            'category_id' => $category,
            'user_id' => $this->user,
        ]);

        $response = $this->delete(route('categories.destroy', $category))
            ->assertRedirect(route('categories.index'));

        $this->followRedirects($response)
            ->assertDontSee($category->name);

        $this->get(route('transactions.index'))
            ->assertDontSee($transaction->description);
    }
}
