<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test user profile page.
     *
     * @group user-controller
     * @return void
     */
    public function testProfile()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get(route('user.show', app()->getLocale()))
            ->assertOk()
            ->assertSee($user->name)
            ->assertSee($user->email)
            ->assertSee(strtoupper($user->role))
            ->assertSee($user->created_at->format('d F Y | H:i:s'))
            ->assertSee($user->updated_at->format('d F Y | H:i:s'));
    }

    /**
     * Test edit user profile page.
     *
     * @group user-controller
     * @return void
     */
    public function testEdit()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get(route('user.edit', app()->getLocale()))
            ->assertOk()
            ->assertSee(route('user.update', app()->getLocale()))
            ->assertSee(method_field('PATCH'));
    }

    /**
     * Test update user.
     *
     * @group user-controller
     * @return void
     */
    public function testUpdate()
    {
        $user = factory(User::class)->create();

        $formData = [
            'name' => 'User Test',
            'email' => 'user_test@localhost'
        ];

        $this->actingAs($user)
            ->patch(route('user.update', app()->getLocale()), $formData)
            ->assertRedirect(route('user.show', app()->getLocale()));

        $this->assertTrue(User::whereEmail('user_test@localhost')->exists());
    }

    /**
     * Test delete user.
     *
     * @group user-controller
     * @return void
     */
    public function testDelete()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->delete(route('user.destroy', app()->getLocale()))
            ->assertRedirect(route('welcome', app()->getLocale()));

        $this->assertFalse($user->exists());
    }
}
