<?php

namespace Domains\Accounts\Tests\Feature\Repositories;

use Domains\Accounts\Database\Factories\UserFactory;
use Domains\Accounts\Enums\UserRolesEnum;
use Domains\Accounts\Notifications\AccountCreatedNotification;
use Domains\Accounts\Repositories\TeacherRepository;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class TeacherRepositoryTest extends TestCase
{
    use WithFaker;

    private TeacherRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new TeacherRepository();
    }

    /** @test */
    public function it_stores_teacher_accounts_and_dispatches_registered_event(): void
    {
        Notification::fake();

        $name = $this->faker->name;
        $email = $this->faker->safeEmail;
        $role = UserRolesEnum::TEACHER;

        $newTeacher = $this->repository->store($name, $email, $role);

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email,
            'role' => $role,
        ]);

        Notification::assertSentTo($newTeacher, AccountCreatedNotification::class);
    }

    /** @test */
    public function it_lists_teachers_accounts(): void
    {
        $teacher = UserFactory::new()->role(UserRolesEnum::HEADTEACHER)->create();
        $headteacher = UserFactory::new()->role(UserRolesEnum::HEADTEACHER)->create();

        $teachersList = $this->repository->list();

        self::assertInstanceOf(Paginator::class, $teachersList);
        self::assertTrue($teachersList->contains($teacher));
        self::assertTrue($teachersList->contains($headteacher));
    }

    /** @test */
    public function it_updates_teachers_accounts(): void
    {
        $teacher = UserFactory::new()->role(UserRolesEnum::TEACHER)->create();

        $updatedTeacher = $this->repository->update(
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

        self::assertTrue($this->repository->delete($teacher));

        $this->assertSoftDeleted('users', [
            'id' => $teacher->id,
        ]);
    }

    /** @test */
    public function it_send_email_validation_notification_when_teacher_updates_email(): void
    {
        Notification::fake();

        $teacher = UserFactory::new()->create();

        $this->repository->update(
            $teacher,
            $teacher->name,
            $this->faker->safeEmail,
            $teacher->role,
        );

        Notification::assertSentTo($teacher, VerifyEmail::class);
    }

    /** @test */
    public function it_filters_teachers_by_name(): void
    {
        $teacher1 = UserFactory::new()->role(UserRolesEnum::TEACHER)->create(['name' => 'Teacher 1']);
        $teacher2 = UserFactory::new()->role(UserRolesEnum::HEADTEACHER)->create(['name' => 'Teacher 2']);

        $filteredTeachers = $this->repository->search('Teacher 1');

        self::assertCount(1, $filteredTeachers->getCollection());
        self::assertTrue($filteredTeachers->getCollection()->contains('name', '=', $teacher1->name));
        self::assertFalse($filteredTeachers->getCollection()->contains('name', '=', $teacher2->name));
    }

    /** @test */
    public function it_filters_teachers_by_email(): void
    {
        $teacher1 = UserFactory::new()->role(UserRolesEnum::TEACHER)->create(['email' => 'teacher1@getsyllabus.app']);
        $teacher2 = UserFactory::new()->role(UserRolesEnum::HEADTEACHER)->create(['email' => 'teacher2@getsyllabus.app']);

        $filteredTeachers = $this->repository->search('teacher1@getsyllabus.app');

        self::assertCount(1, $filteredTeachers->getCollection());
        self::assertTrue($filteredTeachers->getCollection()->contains('email', '=', $teacher1->email));
        self::assertFalse($filteredTeachers->getCollection()->contains('email', '=', $teacher2->email));
    }
}
