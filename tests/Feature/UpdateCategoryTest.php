<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateCategoryTest extends TestCase
{
    use WithFaker;
    use DatabaseMigrations;

    /** @test */
    public function it_can_update_category()
    {
        $category = Category::factory()->create(['user_id' => $this->user]);

        $newCategory = Category::factory()->make();

        $response = $this->put(route('categories.update', $category), $newCategory->toArray())
            ->assertRedirect(route('categories.index'));

        $this->followRedirects($response)
            ->assertSee($newCategory->name)
            ->assertSee($newCategory->slug);
    }

    /** @test */
    public function it_cannot_update_category_without_a_name()
    {
        $category = Category::factory(['user_id' => $this->user])->create();

        $this->put(route('categories.update', $category), ['name' => null])
            ->assertSessionHasErrors('name');
    }
}
