<?php

namespace Tests\Unit;

use App\User;
use App\UserRole;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    use WithFaker;

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
     * Test index users.
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
     * Test create user.
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
            'password' => \Hash::make('password'),
            'role' => UserRole::USER,
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertTrue(User::count() === ($prevUserCount + 1));
    }

    /**
     * Test update.
     *
     * @group user
     *
     * @return void
     */
    public function testUpdate()
    {
        $user = User::firstOrFail();
        $user->name = 'Test Update';
        $user->save();

        $this->assertTrue(User::whereName('Test Update')->exists());
    }

    /**
     * Test delete.
     *
     * @group user
     * @return void
     */
    public function testDelete()
    {
        $user = User::firstOrFail();
        $user->forceDelete();

        $this->assertFalse(User::whereEmail($user->email)->exists());
    }
}
