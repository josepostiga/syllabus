<?php

namespace Domains\Accounts\Repositories;

use Domains\Accounts\Enums\UserRolesEnum;
use Domains\Accounts\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    public function storeTeacher(string $name, string $email): User
    {
        $newTeacher = $this->store($name, $email, UserRolesEnum::TEACHER);

        event(new Registered($newTeacher));

        return $newTeacher;
    }

    /**
     * @return Collection<User>
     */
    public function listTeachers(): Collection
    {
        return User::roles([UserRolesEnum::TEACHER, UserRolesEnum::HEADTEACHER])->get();
    }

    private function store(string $name, string $email, string $role): User
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'role' => $role,
        ]);
    }
}
