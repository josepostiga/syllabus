<?php

namespace Tests\Feature\Controllers\TeachersController;

use Domains\Accounts\Database\Factories\UserFactory;
use Domains\Accounts\Enums\UserRolesEnum;
use Domains\Accounts\Repositories\TeacherRepository;
use Domains\Accounts\Tests\DataProviders\UserRolesDataProvider;
use Illuminate\Pagination\Paginator;
use Tests\TestCase;

class ControllerIndexTest extends TestCase
{
    use UserRolesDataProvider;

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
    public function it_lists_teachers(): void
    {
        $teachersList = new Paginator([
            UserFactory::new()->role(UserRolesEnum::TEACHER)->create(),
            UserFactory::new()->role(UserRolesEnum::HEADTEACHER)->create(),
        ], 15);

        $this->mock(TeacherRepository::class)
            ->shouldReceive('list')
            ->andReturn($teachersList);

        $this->actingAs(UserFactory::new()->role(UserRolesEnum::DIRECTOR)->create())
            ->get(route('accounts.teachers.index'))
            ->assertViewIs('accounts.teachers.index')
            ->assertViewHas('teachers', $teachersList);
    }

    /** @test */
    public function it_filters_teachers_when_search_query_param_is_non_empty(): void
    {
        $this->mock(TeacherRepository::class)
            ->shouldReceive('search')
            ->with('search-string')
            ->andReturn(new Paginator([], 15));

        $this->actingAs(UserFactory::new()->role(UserRolesEnum::DIRECTOR)->create())
            ->get(route('accounts.teachers.index', ['search' => 'search-string']))
            ->assertSuccessful();
    }
}
