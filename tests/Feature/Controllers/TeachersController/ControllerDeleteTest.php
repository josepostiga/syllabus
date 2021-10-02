<?php

namespace Tests\Feature\Controllers\TeachersController;

use Domains\Accounts\Database\Factories\UserFactory;
use Domains\Accounts\Enums\UserRolesEnum;
use Domains\Accounts\Models\User;
use Domains\Accounts\Repositories\UserRepository;
use Domains\Accounts\Tests\DataProviders\UserRolesDataProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ControllerDeleteTest extends TestCase
{
    use UserRolesDataProvider;
    use RefreshDatabase;
    use WithFaker;

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
        $this->delete(route('accounts.teachers.delete', $this->teacher))
            ->assertRedirect(route('login'));
    }

    /**
     * @test
     * @dataProvider unauthorizedUserRolesToHandleTeachers
     */
    public function it_forbids_access_to_route_to_unauthorized_user_roles(string $role): void
    {
        $this->actingAs(UserFactory::new()->role($role)->create())
            ->delete(route('accounts.teachers.delete', $this->teacher))
            ->assertForbidden();
    }

    /** @test */
    public function it_forbids_access_to_route_if_accessed_records_is_the_authenticated_user(): void
    {
        $this->actingAs($this->director)
            ->delete(route('accounts.teachers.delete', $this->director))
            ->assertForbidden();
    }

    /** @test */
    public function it_deletes_teacher(): void
    {
        $this->mock(UserRepository::class)
            ->shouldReceive('deleteTeacher')
            ->once()
            ->with(
                \Mockery::on(fn (User $teacherToUpdate) => $teacherToUpdate->is($this->teacher))
            );

        $this->actingAs($this->director)
            ->delete(route('accounts.teachers.delete', $this->teacher))
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('accounts.teachers.index'))
            ->assertSessionHas('message');
    }
}
