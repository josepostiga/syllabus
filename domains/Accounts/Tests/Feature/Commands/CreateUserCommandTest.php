<?php

namespace Domains\Accounts\Tests\Feature\Commands;

use Domains\Accounts\Enums\UserRolesEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CreateUserCommandTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_fails_if_missing_required_input(): void
    {
        $this->expectException(ValidationException::class);

        $this->artisan('accounts:create-user')
            ->expectsQuestion(__('accounts::auth.name'), '')
            ->expectsQuestion(__('accounts::auth.email'), '')
            ->expectsChoice(__('accounts::auth.role'), UserRolesEnum::DIRECTOR, [UserRolesEnum::DIRECTOR]);
    }

    /** @test */
    public function it_creates_a_user_with_director_role(): void
    {
        $this->travelTo(now());

        $this->artisan('accounts:create-user')
            ->expectsQuestion(__('accounts::auth.name'), $name = $this->faker->name)
            ->expectsQuestion(__('accounts::auth.email'), $email = $this->faker->safeEmail)
            ->expectsChoice(__('accounts::auth.role'), $role = UserRolesEnum::DIRECTOR, [UserRolesEnum::DIRECTOR])
            ->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email,
            'role' => $role,
            'email_verified_at' => now(),
        ]);
    }
}
