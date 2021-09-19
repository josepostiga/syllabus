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
        Event::fake([Registered::class]);

        $name = $this->faker->name;
        $email = $this->faker->safeEmail;
        $role = UserRolesEnum::TEACHER;

        $newTeacher = $this->repository->storeTeacher($name, $email, $role);

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email,
            'role' => $role,
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

    /** @test */
    public function it_updates_teachers_accounts(): void
    {
        $teacher = UserFactory::new()->role(UserRolesEnum::TEACHER)->create();

        $updatedTeacher = $this->repository->updateTeacher(
            $teacher,
            $this->faker->name,
            $this->faker->safeEmail,
            UserRolesEnum::HEADTEACHER
        );

        // Check that we're working with the updated record
        self::assertTrue($teacher->is($updatedTeacher));

        $this->assertDatabaseHas('users', [
            'id' => $updatedTeacher->id,
            'name' => $updatedTeacher->name,
            'email' => $updatedTeacher->email,
            'role' => $updatedTeacher->role,
        ]);
    }

    /** @test */
    public function it_deletes_teacher(): void
    {
        $teacher = UserFactory::new()->role(UserRolesEnum::TEACHER)->create();

        self::assertTrue($this->repository->deleteTeacher($teacher));

        $this->assertSoftDeleted('users', [
            'id' => $teacher->id,
        ]);
    }
}
