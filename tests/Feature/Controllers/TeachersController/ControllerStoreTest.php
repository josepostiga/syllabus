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

class ControllerStoreTest extends TestCase
{
    use RefreshDatabase;
    use UserRolesDataProvider;
    use WithFaker;

    private User $director;

    protected function setUp(): void
    {
        parent::setUp();

        $this->director = UserFactory::new()->role(UserRolesEnum::DIRECTOR)->create();
    }

    /** @test */
    public function it_protects_access_to_route_to_authenticated_users(): void
    {
        $this->post(route('accounts.teachers.store'))
            ->assertRedirect(route('login'));
    }

    /**
     * @test
     * @dataProvider unauthorizedUserRolesToHandleTeachers
     */
    public function it_forbids_access_to_route_to_unauthorized_user_roles(string $role): void
    {
        $this->actingAs(UserFactory::new()->role($role)->create())
            ->post(route('accounts.teachers.store'))
            ->assertForbidden();
    }

    /** @test */
    public function it_fails_to_store_teacher_with_invalid_input(): void
    {
        $this->actingAs($this->director)
            ->post(route('accounts.teachers.store'))
            ->assertSessionHasErrors(['name', 'email', 'role']);
    }

    /** @test */
    public function it_fails_to_store_teacher_with_an_already_registered_email(): void
    {
        // We'll use the user's email created on the setUp() method, for simplicity
        $payload = [
            'name' => $this->faker->name,
            'email' => $this->director->email,
            'role' => $this->director->role,
        ];

        $this->actingAs($this->director)
            ->post(route('accounts.teachers.store'), $payload)
            ->assertSessionHasErrors(['email']);
    }

    /**
     * @test
     * @dataProvider invalidUserRolesForTeachers
     */
    public function it_fails_to_store_teacher_with_invalid_role(string $invalidRole): void
    {
        $payload = [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'role' => $invalidRole,
        ];

        $this->actingAs($this->director)
            ->post(route('accounts.teachers.store'), $payload)
            ->assertSessionHasErrors(['role']);
    }

    /** @test */
    public function it_stores_teacher(): void
    {
        $payload = [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'role' => UserRolesEnum::TEACHER,
        ];

        $this->mock(UserRepository::class)
            ->shouldReceive('storeTeacher')
            ->once()
            ->with($payload['name'], $payload['email'], $payload['role'])
            ->andReturn(
                new User([
                    'name' => $payload['name'],
                    'email' => $payload['email'],
                    'role' => $payload['role'],
                ])
            );

        $this->actingAs($this->director)
            ->post(route('accounts.teachers.store'), $payload)
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('accounts.teachers.index'))
            ->assertSessionHas('message');
    }
}
