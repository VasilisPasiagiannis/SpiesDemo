<?php

namespace App\Domains\Auth\Models;

use App\Domains\Auth\Models\Traits\Method\UserMethod;
use Laravel\Sanctum\HasApiTokens;
use Database\Factories\UserFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;

/**
 * @method find(string $userId)
 * @method static create(array $array)
 */
class User extends Authenticatable implements MustVerifyEmailContract
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        TwoFactorAuthenticatable,
        HasRoles,
        SoftDeletes,
        UserMethod;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'password_changed_at',
        'active',
        'last_login_at',
        'last_login_ip',
        'to_be_logged_out',
        'profile_photo_path',
        'user_verified',
        'user_verified_at',
        'uuid'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'active' => 'boolean',
        'last_login_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'to_be_logged_out' => 'boolean',
        'user_verified' => 'boolean',
        'user_verified_at' => 'datetime',
    ];

    protected static function newFactory() {
        return UserFactory::new();
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    // need for api sanctum
    protected function getDefaultGuardName(): string
    {
        return 'web';
    }


}
