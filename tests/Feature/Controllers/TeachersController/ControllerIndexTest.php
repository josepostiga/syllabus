<?php

namespace Controllers\TeachersController;

use Domains\Accounts\Database\Factories\UserFactory;
use Domains\Accounts\Enums\UserRolesEnum;
use Domains\Accounts\Tests\Traits\UserRolesProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ControllerIndexTest extends TestCase
{
    use RefreshDatabase;
    use UserRolesProvider;

    /** @test */
    public function it_protects_access_to_route_to_authenticated_users(): void
    {
        $this->get(route('accounts.teachers.index'))
            ->assertRedirect(route('login'));
    }

    /**
     * @test
     * @dataProvider unauthorizedUserRolesToHandleTeachers
     */
    public function it_forbids_access_to_route_to_unauthorized_user_roles(string $role): void
    {
        $this->actingAs(UserFactory::new()->role($role)->create())
            ->get(route('accounts.teachers.store'))
            ->assertForbidden();
    }

    /** @test */
    public function it_renders_page(): void
    {
        $this->actingAs(UserFactory::new()->role(UserRolesEnum::DIRECTOR)->create())
            ->get(route('accounts.teachers.index'))
            ->assertViewIs('accounts.teachers.index');
    }
}
