<?php

namespace Tests\Unit\Layouts;

use Domains\Accounts\Database\Factories\UserFactory;
use Domains\Accounts\Enums\UserRolesEnum;
use Illuminate\View\ComponentAttributeBag;
use Tests\TestCase;

class NavigationTest extends TestCase
{
    /** @test */
    public function it_shows_teachers_menu_for_directors(): void
    {
        $director = UserFactory::new()->role(UserRolesEnum::DIRECTOR)->make();

        $this->view('components.navigation.nav', ['authenticatedUser' => $director, 'attributes' => new ComponentAttributeBag()])
            ->assertSee(route('accounts.teachers.index'));
    }
}
