<?php

namespace Tests\Feature\Controllers\TeachersController;

use Domains\Accounts\Database\Factories\UserFactory;
use Domains\Accounts\Enums\UserRolesEnum;
use Domains\Accounts\Models\User;
use Domains\Accounts\Tests\Traits\UserRolesProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ControllerCreateTest extends TestCase
{
    use RefreshDatabase;
    use UserRolesProvider;

    private User $director;

    protected function setUp(): void
    {
        parent::setUp();

        $this->director = UserFactory::new()->role(UserRolesEnum::DIRECTOR)->create();
    }

    /** @test */
    public function it_protects_access_to_route_to_authenticated_users(): void
    {
        $this->get(route('accounts.teachers.store'))
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
        $this->actingAs($this->director)
            ->get(route('accounts.teachers.create'))
            ->assertViewIs('accounts.teachers.create')
            ->assertViewHas('roles');
    }
}
