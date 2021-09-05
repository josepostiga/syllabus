<?php

namespace Tests\Feature\Controllers\TeachersController;

use Domains\Accounts\Database\Factories\UserFactory;
use Domains\Accounts\Enums\UserRolesEnum;
use Domains\Accounts\Models\User;
use Domains\Accounts\Tests\Traits\UserRolesProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ControllerUpdateTest extends TestCase
{
    use UserRolesProvider;
    use RefreshDatabase;

    private User $director;
    private User $teacher;

    protected function setUp(): void
    {
        parent::setUp();

        $this->director = UserFactory::new()->role(UserRolesEnum::DIRECTOR)->create();
        $this->teacher = UserFactory::new()->role(UserRolesEnum::TEACHER)->create();
    }

    /** @test */
    public function it_protects_access_to_route_to_authenticated_users(): void
    {
        $this->patch(route('accounts.teachers.update', $this->teacher))
            ->assertRedirect(route('login'));
    }

    /**
     * @test
     * @dataProvider unauthorizedUserRolesToHandleTeachers
     */
    public function it_forbids_access_to_route_to_unauthorized_user_roles(string $role): void
    {
        $this->actingAs(UserFactory::new()->role($role)->create())
            ->patch(route('accounts.teachers.update', $this->teacher))
            ->assertForbidden();
    }

    /** @test */
    public function it_forbids_access_to_route_if_accessed_records_is_the_authenticated_user(): void
    {
        $this->actingAs($this->director)
            ->patch(route('accounts.teachers.show', $this->director))
            ->assertForbidden();
    }

    /** @test */
    public function it_updates_teacher(): void
    {
        $payload = [];

        $this->actingAs($this->director)
            ->patch(route('accounts.teachers.update', $this->teacher), $payload)
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('accounts.teachers.show', $this->teacher))
            ->assertSessionHas('message');
    }
}
