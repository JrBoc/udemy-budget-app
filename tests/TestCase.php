<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;

    /** @var \App\Models\User */
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();;

        $this->signIn($this->user = User::factory()->create());
    }

    protected function signIn($user)
    {
        $this->actingAs($user);
        return $this;
    }

    protected function signOut()
    {
        $this->post(route('logout'));
        return $this;
    }
}
