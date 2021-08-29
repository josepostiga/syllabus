<?php

namespace Domains\Accounts\Tests\Feature\Repositories;

use Domains\Accounts\Database\Factories\UserFactory;
use Domains\Accounts\Enums\UserRolesEnum;
use Domains\Accounts\Repositories\UserRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private UserRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new UserRepository();
    }

    /** @test */
    public function it_stores_teacher_accounts_and_sends_confirmation_email(): void
    {
        Event::fake();

        $name = $this->faker->name;
        $email = $this->faker->safeEmail;

        $newTeacher = $this->repository->storeTeacher($name, $email);

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email,
            'role' => UserRolesEnum::TEACHER,
        ]);

        Event::assertDispatched(Registered::class, fn (Registered $event): bool => $event->user->is($newTeacher));
    }

    /** @test */
    public function it_lists_teachers_accounts(): void
    {
        $teacher = UserFactory::new()->role(UserRolesEnum::HEADTEACHER)->create();
        $headteacher = UserFactory::new()->role(UserRolesEnum::HEADTEACHER)->create();

        $teachersList = $this->repository->listTeachers();

        self::assertTrue($teachersList->contains($teacher));
        self::assertTrue($teachersList->contains($headteacher));
    }
}
