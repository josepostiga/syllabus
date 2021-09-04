<?php

namespace Domains\Accounts\Database\Seeders;

use Domains\Accounts\Database\Factories\UserFactory;
use Domains\Accounts\Enums\UserRolesEnum;
use Illuminate\Database\Seeder;

class TeachersSeeder extends Seeder
{
    public function run(): void
    {
        UserFactory::times(10)->role(UserRolesEnum::TEACHER)->create();
        UserFactory::times(2)->role(UserRolesEnum::HEADTEACHER)->create();
    }
}
