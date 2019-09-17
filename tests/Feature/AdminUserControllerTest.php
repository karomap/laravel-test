<?php

namespace Tests\Feature;

use App\User;
use App\UserRole;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminUserControllerTest extends TestCase
{
    use DatabaseMigrations;
    use WithFaker;

    /**
     * Admin user.
     *
     * @var \App\User
     */
    protected $admin;

    /**
     * Non-admin user.
     *
     * @var \App\User
     */
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = factory(User::class)->state(UserRole::ADMIN)->create();
        factory(User::class, 10)->create();
        $this->user = User::whereRole(UserRole::USER)->first();
    }

    /**
     * Test index users.
     *
     * @group admin-user-controller
     * @return void
     */
    public function testIndex()
    {
        $url = route('admin.user.index', app()->getLocale());

        $this->actingAs($this->user)
            ->get($url)
            ->assertStatus(403);

        $this->actingAs($this->admin)
            ->get($url)
            ->assertOk();
    }

    /**
     * Test create user page.
     *
     * @group admin-user-controller
     * @return void
     */
    public function testCreate()
    {
        $url = route('admin.user.create', app()->getLocale());

        $this->actingAs($this->user)
            ->get($url)
            ->assertStatus(403);

        $this->actingAs($this->admin)
            ->get($url)
            ->assertOk();
    }

    /**
     * Test store user.
     *
     * @group admin-user-controller
     * @return void
     */
    public function testStore()
    {
        $url = route('admin.user.store', app()->getLocale());

        $formData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => UserRole::USER,
        ];

        User::whereEmail($formData['email'])->forceDelete();

        $this->actingAs($this->user)
            ->post($url, $formData)
            ->assertStatus(403);

        $this->actingAs($this->admin)
            ->post($url, $formData)
            ->assertRedirect(route('admin.user.index', app()->getLocale()));

        $this->assertTrue(User::whereEmail($formData['email'])->exists());
    }

    /**
     * Test edit user page.
     *
     * @group admin-user-controller
     * @return void
     */
    public function testEdit()
    {
        $url = route('admin.user.edit', [app()->getLocale(), $this->user]);

        $this->actingAs($this->user)
            ->get($url)
            ->assertStatus(403);

        $this->actingAs($this->admin)
            ->get($url)
            ->assertOk();
    }

    /**
     * Test update user.
     *
     * @group admin-user-controller
     * @return void
     */
    public function testUpdate()
    {
        $url = route('admin.user.update', [app()->getLocale(), $this->user]);

        $formData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => UserRole::USER,
        ];

        $this->actingAs($this->user)
            ->patch($url, $formData)
            ->assertStatus(403);

        $this->actingAs($this->admin)
            ->patch($url, $formData)
            ->assertRedirect(route('admin.user.index', app()->getLocale()));
    }

    /**
     * Test delete user.
     *
     * @group admin-user-controller
     * @return void
     */
    public function testDelete()
    {
        $user = factory(User::class)->create();
        $this->assertTrue($user->exists());

        $url = route('admin.user.destroy', [app()->getLocale(), $user]);

        $this->actingAs($this->user)
            ->delete($url)
            ->assertStatus(403);

        $this->actingAs($this->admin)
            ->delete($url)
            ->assertRedirect(route('admin.user.index', app()->getLocale()));

        $this->assertNull(User::find($user->id));
    }
}
