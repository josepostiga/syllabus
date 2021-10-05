<?php

namespace Domains\Accounts\Tests\DataProviders;

use Domains\Accounts\Enums\UserRolesEnum;
use JetBrains\PhpStorm\ArrayShape;

trait UserRolesDataProvider
{
    #[ArrayShape(['Headteacher' => 'array', 'Parent' => 'array', 'Student' => 'array', 'Teacher' => 'array'])]
    public function unauthorizedUserRolesToHandleTeachers(): array
    {
        return [
            'Headteacher' => [UserRolesEnum::HEADTEACHER],
            'Parent' => [UserRolesEnum::PARENT],
            'Student' => [UserRolesEnum::STUDENT],
            'Teacher' => [UserRolesEnum::TEACHER],
        ];
    }

    #[ArrayShape(['Director' => 'array', 'Parent' => 'array', 'Student' => 'array'])]
    public function invalidUserRolesForTeachers(): array
    {
        return [
            'Director' => [UserRolesEnum::DIRECTOR],
            'Parent' => [UserRolesEnum::PARENT],
            'Student' => [UserRolesEnum::STUDENT],
        ];
    }
}
