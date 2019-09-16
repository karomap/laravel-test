<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GeneralTest extends TestCase
{
    /**
     * Test welcome page
     *
     * @group general
     * @return void
     */
    public function testWelcomePage()
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSee(\Config::get('app.name'))
            ->assertSee('Login')
            ->assertSee('Register');
    }

    /**
     * Test home page
     *
     * @group general
     * @return void
     */
    public function testHomePage()
    {
        $this->get('/home')
            ->assertStatus(302)
            ->assertLocation('/login');

        $user = User::firstOrCreate(
            factory(User::class)->make()->getAttributes()
        );

        $this->actingAs($user)
            ->get('/home')
            ->assertStatus(200)
            ->assertSee('You are logged in!');
    }
}
