<?php

namespace Database\Seeders;

use Domains\Accounts\Database\Seeders\TeachersSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TeachersSeeder::class,
        ]);
    }
}
