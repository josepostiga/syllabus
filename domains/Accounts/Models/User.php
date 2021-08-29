<?php

namespace Domains\Accounts\Models;

use Domains\Accounts\Enums\UserRolesEnum;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable;

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

    public function getRoleAttribute(string $role): string
    {
        return Str::lower($role);
    }

    public function isDirector(): bool
    {
        return $this->role === Str::lower(UserRolesEnum::DIRECTOR);
    }

    public function isTeacher(): bool
    {
        return $this->role === Str::lower(UserRolesEnum::TEACHER);
    }

    public function isHeadTeacher(): bool
    {
        return $this->role === Str::lower(UserRolesEnum::HEADTEACHER);
    }

    public function scopeRoles(Builder $builder, array $roles): Builder
    {
        return $builder->whereIn('role', $roles);
    }
}
