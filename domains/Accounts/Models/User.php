<?php

namespace Domains\Accounts\Models;

use Domains\Accounts\Enums\UserRolesEnum;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'email',
        'name',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isDirector(): bool
    {
        return $this->role === UserRolesEnum::DIRECTOR;
    }

    public function isTeacher(): bool
    {
        return $this->role === UserRolesEnum::TEACHER;
    }

    public function isHeadTeacher(): bool
    {
        return $this->role === UserRolesEnum::HEADTEACHER;
    }

    public function scopeRoles(Builder $builder, array $roles): Builder
    {
        return $builder->whereIn('role', $roles);
    }
}
