<?php

namespace Tests\Feature\Controllers\TeachersController;

use Domains\Accounts\Database\Factories\UserFactory;
use Domains\Accounts\Enums\UserRolesEnum;
use Domains\Accounts\Repositories\UserRepository;
use Domains\Accounts\Tests\DataProviders\UserRolesDataProvider;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class ControllerIndexTest extends TestCase
{
    use RefreshDatabase;
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
        $teachersList = new Collection([
            UserFactory::new()->role(UserRolesEnum::TEACHER)->create(),
            UserFactory::new()->role(UserRolesEnum::HEADTEACHER)->create(),
        ]);

        $this->mock(UserRepository::class, static function (MockInterface $mockedUserRepository) use ($teachersList): void {
            $mockedUserRepository->shouldReceive('listTeachers')
                ->andReturn($teachersList);
        });

        $this->actingAs(UserFactory::new()->role(UserRolesEnum::DIRECTOR)->create())
            ->get(route('accounts.teachers.index'))
            ->assertViewIs('accounts.teachers.index')
            ->assertViewHas('teachers', $teachersList);
    }
}
