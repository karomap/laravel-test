<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GeneralTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test welcome page.
     *
     * @group general
     * @return void
     */
    public function testWelcomePage()
    {
        $this->get(route('welcome', app()->getLocale()))
            ->assertOk()
            ->assertSee(\Config::get('app.name'))
            ->assertSee(\Lang::get('Login'))
            ->assertSee(\Lang::get('Register'));
    }

    /**
     * Test home page.
     *
     * @group general
     * @return void
     */
    public function testHomePage()
    {
        $this->get(route('home', app()->getLocale()))
            ->assertRedirect(route('login', app()->getLocale()));

        $user = User::firstOrCreate(
            factory(User::class)->make()->getAttributes()
        );

        $this->actingAs($user)
            ->get(route('home', app()->getLocale()))
            ->assertOk()
            ->assertSee('You are logged in!');
    }

    /**
     * Test login.
     *
     * @group general
     * @return void
     */
    public function testLogin()
    {
        $user = factory(User::class)->make();
        User::whereEmail($user->email)->forceDelete();
        $user->password = \Hash::make('password');
        $user->save();

        $formData = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $this->post(route('login', app()->getLocale()), $formData)
            ->assertRedirect(route('home', app()->getLocale()));
    }

    /**
     * Test register.
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
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->post(route('register', app()->getLocale()), $formData)
            ->assertRedirect(route('home', app()->getLocale()));
    }
}
