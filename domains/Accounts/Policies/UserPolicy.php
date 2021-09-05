<?php

namespace Domains\Accounts\Policies;

use Domains\Accounts\Models\User;

class UserPolicy
{
    public function before(User $authenticatedUser): ?bool
    {
        return $authenticatedUser->isDirector();
    }

    public function listTeacherAccounts(): bool
    {
        return true;
    }

    public function createTeacherAccounts(): bool
    {
        return true;
    }

    public function showTeacherAccounts(): bool
    {
        return true;
    }

    public function updateTeacherAccounts(): bool
    {
        return true;
    }
}
