<?php

namespace Tests\Unit;

use App\User;
use App\UserRole;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Seed users table
        $userCount = User::whereRole(UserRole::USER)->count();
        if ($userCount < 10) {
            factory(User::class, 10)->create();
        }
    }
    /**
     * Test index users
     *
     * @group user
     * @return void
     */
    public function testIndex()
    {
        $this->assertTrue(User::whereRole(UserRole::USER)->count() >= 10);

        $users = User::all();
        $this->assertInstanceOf(Collection::class, $users);

        return $users;
    }

    /**
     * Test create user
     *
     * @group user
     * @return void
     */
    public function testCreate()
    {
        $email = 'test_user_email@localhost';
        User::whereEmail($email)->forceDelete();

        $prevUserCount = User::count();

        $user = User::create([
            'name' => $this->faker->name,
            'email' => $email,
            'email_verified_at' => now(),
            'password' => \Hash::make('secret'),
            'role' => UserRole::USER
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertTrue(User::count() === ($prevUserCount + 1));
    }
}
