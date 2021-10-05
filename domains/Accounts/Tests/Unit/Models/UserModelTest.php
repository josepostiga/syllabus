<?php

namespace Domains\Accounts\Tests\Unit\Models;

use Domains\Accounts\Enums\UserRolesEnum;
use Domains\Accounts\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    private User $model;

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = new User();
    }

    /** @test */
    public function it_uses_correct_table(): void
    {
        self::assertEquals('users', $this->model->getTable());
    }

    /** @test */
    public function it_uses_correct_primary_key_name(): void
    {
        self::assertEquals('id', $this->model->getKeyName());
    }

    /** @test */
    public function it_uses_timestamps(): void
    {
        self::assertTrue($this->model->usesTimestamps());
        self::assertEquals('created_at', $this->model->getCreatedAtColumn());
        self::assertEquals('updated_at', $this->model->getUpdatedAtColumn());
    }

    /** @test */
    public function it_uses_soft_delete(): void
    {
        self::assertTrue($this->isSoftDeletableModel($this->model));
        self::assertEquals('deleted_at', $this->model->getDeletedAtColumn());
    }

    /** @test */
    public function it_can_be_have_a_director_role(): void
    {
        $this->model->role = UserRolesEnum::DIRECTOR;

        self::assertTrue($this->model->isDirector());
    }

    /** @test */
    public function it_can_be_have_a_teacher_role(): void
    {
        $this->model->role = UserRolesEnum::TEACHER;

        self::assertTrue($this->model->isTeacher());
    }

    /** @test */
    public function it_can_be_have_a_headteacher_role(): void
    {
        $this->model->role = UserRolesEnum::HEADTEACHER;

        self::assertTrue($this->model->isHeadTeacher());
    }

    /** @test */
    public function it_implements_email_verification_contract(): void
    {
        self::assertInstanceOf(MustVerifyEmail::class, $this->model);
    }
}
