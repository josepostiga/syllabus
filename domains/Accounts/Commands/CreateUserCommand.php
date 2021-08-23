<?php

namespace Domains\Accounts\Commands;

use Domains\Accounts\Enums\UserRolesEnum;
use Domains\Accounts\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateUserCommand extends Command
{
    protected $signature = 'accounts:create-user';
    protected $description = 'Create a new user accounts';

    public function handle(): int
    {
        $name = $this->ask(__('accounts::properties.name'));
        $email = $this->ask(__('accounts::properties.email'));
        $role = $this->choice(__('accounts::properties.role'), [UserRolesEnum::DIRECTOR]);

        $this->validate($name, $email, $role);

        $this->info(__('accounts::messages.info.user_without_password'));

        $user = new User([
            'name' => $name,
            'email' => $email,
        ]);
        $user->role = $role;
        $user->email_verified_at = now();

        return $user->save() ? static::SUCCESS : static::FAILURE;
    }

    private function validate(?string $name, ?string $email, ?string $role): void
    {
        Validator::make(
            [
                'name' => $name,
                'email' => $email,
                'role' => $role,
            ],
            [
                'name' => ['required', 'string'],
                'email' => ['required', 'email', 'unique:users'],
                'role' => ['required', 'in:'.UserRolesEnum::DIRECTOR],
            ]
        )
            ->validate();
    }
}
