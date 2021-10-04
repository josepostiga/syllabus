<?php

namespace Domains\Accounts\Repositories;

use Domains\Accounts\Enums\UserRolesEnum;
use Domains\Accounts\Models\User;
use Domains\Accounts\Notifications\AccountCreatedNotification;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

class TeacherRepository
{
    public function store(string $name, string $email, string $role): User
    {
        $teacher = User::create([
            'name' => $name,
            'email' => $email,
            'role' => $role,
        ]);

        $teacher->notify(new AccountCreatedNotification());

        return $teacher;
    }

    public function list(int $recordsPerPage = 10): Paginator
    {
        return User::roles([UserRolesEnum::TEACHER, UserRolesEnum::HEADTEACHER])
            ->simplePaginate($recordsPerPage);
    }

    public function update(User $teacher, string $name, string $email, string $role): User
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

    public function delete(User $teacher): ?bool
    {
        return $teacher->delete();
    }

    /**
     * @return Collection<User>
     */
    public function search(string $search): Collection
    {
        return User::roles([UserRolesEnum::TEACHER, UserRolesEnum::HEADTEACHER])
            ->search($search)
            ->get();
    }
}
