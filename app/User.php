<?php

namespace App;

use App\Helpers\BaseEnum;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

abstract class UserRole extends BaseEnum
{
    const ADMIN = 'admin';
    const OPERATOR = 'operator';
    const USER = 'user';
}

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * ==================================================
     * METHODS
     * ==================================================
     */

    /**
     * Check user access level
     *
     * @param string $level
     * @return bool
     */
    public function hasAccessLevel($level)
    {
        if ($this->role === UserRole::ADMIN || $level === UserRole::USER) {
            return true;
        }

        return $this->role === $level;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
