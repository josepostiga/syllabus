<?php

namespace Domains\Accounts\Repositories;

use Domains\Accounts\Enums\UserRolesEnum;
use Domains\Accounts\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    public function storeTeacher(string $name, string $email, string $role): User
    {
        $teacher = User::create([
            'name' => $name,
            'email' => $email,
            'role' => $role,
        ]);

        event(new Registered($teacher));

        return $teacher;
    }

    /**
     * @return Collection<User>
     */
    public function listTeachers(): Collection
    {
        return User::roles([UserRolesEnum::TEACHER, UserRolesEnum::HEADTEACHER])->get();
    }

    public function updateTeacher(User $teacher, string $name, string $email, string $role): User
    {
        $teacher->update([
            'name' => $name,
            'email' => $email,
            'role' => $role,
        ]);

        return $teacher;
    }

    public function deleteTeacher(User $teacher): ?bool
    {
        return $teacher->delete();
    }
}
