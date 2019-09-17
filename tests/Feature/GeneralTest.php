<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GeneralTest extends TestCase
{
    use DatabaseMigrations;

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
            ->assertRedirect('/login');

        $user = User::firstOrCreate(
            factory(User::class)->make()->getAttributes()
        );

        $this->actingAs($user)
            ->get('/home')
            ->assertStatus(200)
            ->assertSee('You are logged in!');
    }

    /**
     * Test login
     *
     * @group general
     * @return void
     */
    public function testLogin()
    {
        $user = factory(User::class)->make();
        User::whereEmail($user->email)->forceDelete();
        $user->password = \Hash::make('secret');
        $user->save();

        $formData = [
            'email' => $user->email,
            'password' => 'secret'
        ];

        $this->post('/login', $formData)
            ->assertRedirect('/home');
    }

    /**
     * Test register
     *
     * @group general
     * @return void
     */
    public function testRegister()
    {
        $user = factory(User::class)->make();
        User::whereEmail($user->email)->forceDelete();

        $formData = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ];

        $this->post('/register', $formData)
            ->assertRedirect('/home');
    }
}
