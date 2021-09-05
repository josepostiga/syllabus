<?php

namespace Tests\Feature\Controllers\TeachersController;

use Domains\Accounts\Database\Factories\UserFactory;
use Domains\Accounts\Enums\UserRolesEnum;
use Domains\Accounts\Models\User;
use Domains\Accounts\Repositories\UserRepository;
use Domains\Accounts\Tests\Traits\UserRolesProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ControllerUpdateTest extends TestCase
{
    use UserRolesProvider;
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
            ->patch(route('accounts.teachers.update', $this->director))
            ->assertForbidden();
    }

    /** @test */
    public function it_fails_to_update_teacher_with_an_already_registered_email(): void
    {
        // We'll use the user's email created on the setUp() method, for simplicity
        $payload = [
            'name' => $this->faker->name,
            'email' => $this->director->email,
        ];

        $this->actingAs($this->director)
            ->patch(route('accounts.teachers.update', $this->teacher), $payload)
            ->assertSessionHasErrors(['email']);
    }

    /**
     * @test
     * @dataProvider invalidUserRolesForTeachers
     */
    public function it_fails_to_update_teacher_with_invalid_role(string $role): void
    {
        $payload = [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'role' => $role,
        ];

        $this->actingAs($this->director)
            ->patch(route('accounts.teachers.update', $this->teacher), $payload)
            ->assertSessionHasErrors(['role']);
    }

    /** @test */
    public function it_updates_teacher(): void
    {
        $payload = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'role' => UserRolesEnum::HEADTEACHER,
        ];

        $this->mock(UserRepository::class)
            ->shouldReceive('updateTeacher')
            ->once()
            ->with(
                \Mockery::on(fn (User $teacherToUpdate) => $teacherToUpdate->is($this->teacher)),
                $payload['name'],
                $payload['email'],
                $payload['role']
            )
            ->andReturn(
                $this->teacher->forceFill([
                    'name' => $payload['name'],
                    'email' => $payload['email'],
                    'role' => $payload['role'],
                ])
            );

        $this->actingAs($this->director)
            ->patch(route('accounts.teachers.update', $this->teacher), $payload)
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('accounts.teachers.show', $this->teacher))
            ->assertSessionHas('message');
    }

    /** @test */
    public function it_updates_teacher_with_non_unique_email_if_its_theirs(): void
    {
        $payload = [
            'name' => $this->faker->name,
            'email' => $this->teacher->email,
            'role' => UserRolesEnum::HEADTEACHER,
        ];

        $this->actingAs($this->director)
            ->patch(route('accounts.teachers.update', $this->teacher), $payload)
            ->assertSessionHasNoErrors();
    }
}
