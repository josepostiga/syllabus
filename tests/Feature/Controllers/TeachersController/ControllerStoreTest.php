<?php

namespace Tests\Feature\Controllers\TeachersController;

use Domains\Accounts\Database\Factories\UserFactory;
use Domains\Accounts\Enums\UserRolesEnum;
use Domains\Accounts\Models\User;
use Domains\Accounts\Repositories\UserRepository;
use Domains\Accounts\Tests\Traits\UserRolesProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\MockInterface;
use Tests\TestCase;

class ControllerStoreTest extends TestCase
{
    use RefreshDatabase;
    use UserRolesProvider;
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
    public function it_renders_page(): void
    {
        $this->actingAs($this->director)
            ->get(route('accounts.teachers.create'))
            ->assertViewIs('accounts.teachers.create');
    }

    /** @test */
    public function it_fails_to_store_teacher_with_invalid_input(): void
    {
        $this->actingAs($this->director)
            ->post(route('accounts.teachers.store'))
            ->assertSessionHasErrors(['name', 'email']);
    }

    /** @test */
    public function it_fails_to_store_teacher_with_an_already_registered_email(): void
    {
        // We'll use the user's email created on the setUp() method, for simplicity
        $payload = [
            'name' => $this->faker->name,
            'email' => $this->director->email,
        ];

        $this->actingAs($this->director)
            ->post(route('accounts.teachers.store'), $payload)
            ->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function it_stores_teacher(): void
    {
        $payload = [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
        ];

        $this->mock(UserRepository::class, static function (MockInterface $mockedUserRepository) use ($payload) {
            $mockedUserRepository->shouldReceive('storeTeacher')
                ->with($payload['name'], $payload['email'])
                ->andReturn(
                    new User([
                        'name' => $payload['name'],
                        'email' => $payload['email'],
                    ])
                );
        });

        $this->actingAs($this->director)
            ->post(route('accounts.teachers.store'), $payload)
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('accounts.teachers.index'))
            ->assertSessionHas('message');
    }
}
