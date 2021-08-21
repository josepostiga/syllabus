<?php

namespace Domains\Accounts\Tests\Traits;

use Domains\Accounts\Enums\UserRolesEnum;

trait UserRolesProvider
{
    public function unauthorizedUserRolesToHandleTeachers(): array
    {
        return [
            'Headteacher' => [UserRolesEnum::HEADTEACHER],
            'Parent' => [UserRolesEnum::PARENT],
            'Student' => [UserRolesEnum::STUDENT],
            'Teacher' => [UserRolesEnum::TEACHER],
        ];
    }
}
