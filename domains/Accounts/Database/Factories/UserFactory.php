<?php

namespace Domains\Accounts\Database\Factories;

use Domains\Accounts\Enums\UserRolesEnum;
use Domains\Accounts\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use function now;

/**
 * @method User create($attributes = [], ?Model $parent = null);
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'role' => UserRolesEnum::DIRECTOR,
        ];
    }

    public function unverified(): self
    {
        return $this->state(fn (): array => [
            'email_verified_at' => null,
        ]);
    }

    public function role(string $role): self
    {
        return $this->state(fn (): array => [
            'role' => $role,
        ]);
    }
}
