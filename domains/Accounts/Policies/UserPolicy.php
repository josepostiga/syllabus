<?php

namespace Domains\Accounts\Policies;

use Domains\Accounts\Models\User;

class UserPolicy
{
    public function listTeacherAccounts(User $authenticatedUser): bool
    {
        return $authenticatedUser->isDirector();
    }

    public function createTeacherAccounts(User $authenticatedUser): bool
    {
        return $authenticatedUser->isDirector();
    }

    public function showTeacherAccounts(User $authenticatedUser, User $teacher): bool
    {
        return $authenticatedUser->isDirector() && $authenticatedUser->isNot($teacher);
    }

    public function updateTeacherAccounts(User $authenticatedUser, User $teacher): bool
    {
        return $authenticatedUser->isDirector() && $authenticatedUser->isNot($teacher);
    }
}
