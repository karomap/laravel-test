<?php

use App\User;
use App\UserRole;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (UserRole::getConstants() as $role) {
            factory(User::class)->create([
                'name' => \Str::title($role),
                'email' => "$role@localhost",
                'password' => \Hash::make($role),
                'role' => $role,
            ]);
        }
    }
}
