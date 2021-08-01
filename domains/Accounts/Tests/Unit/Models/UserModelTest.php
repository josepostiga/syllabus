<?php

namespace Domains\Accounts\Tests\Unit\Models;

use Domains\Accounts\Enums\UserRolesEnum;
use Domains\Accounts\Models\User;
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
    public function it_can_be_have_a_director_role(): void
    {
        $this->model->role = UserRolesEnum::DIRECTOR;

        self::assertTrue($this->model->isDirector());
    }
}
