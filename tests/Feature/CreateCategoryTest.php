<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCategoryTest extends TestCase
{
    use WithFaker;
    use DatabaseMigrations;

    /** @test */
    public function it_can_create_category()
    {
        $category = Category::factory()
            ->create([
                'user_id' => $this->user,
            ]);

        $response = $this->post(route('categories.store'), $category->toArray())
            ->assertRedirect(route('categories.index'));

        $this->followRedirects($response)->assertSee($category->name);
    }

    /** @test */
    public function it_cannot_create_transactions_without_a_name()
    {
        $this->post(route('categories.store'), ['name' => null])
            ->assertSessionHasErrors('name');
    }
}
