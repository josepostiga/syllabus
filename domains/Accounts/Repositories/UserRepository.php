<?php

namespace Domains\Accounts\Repositories;

use Domains\Accounts\Enums\UserRolesEnum;
use Domains\Accounts\Models\User;
use Domains\Accounts\Notifications\AccountCreatedNotification;
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

        $teacher->notify(new AccountCreatedNotification());

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
        $teacher->fill([
            'name' => $name,
            'email' => $email,
            'role' => $role,
        ]);

        if ($teacher->isDirty(['email'])) {
            $teacher->forceFill(['email_verified_at' => null]);
        }

        $teacher->update();

        if (!$teacher->hasVerifiedEmail()) {
            $teacher->sendEmailVerificationNotification();
        }

        return $teacher;
    }

    public function deleteTeacher(User $teacher): ?bool
    {
        return $teacher->delete();
    }
}
