<?php

namespace Tests\Feature\Controllers\Auth;

use Domains\Accounts\Database\Factories\UserFactory;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function login_screen_can_be_rendered(): void
    {
        $this->get(route('login'))
            ->assertStatus(200);
    }

    /** @test */
    public function users_can_authenticate_using_the_login_screen(): void
    {
        $user = UserFactory::new()->create();

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ])
            ->assertRedirect(RouteServiceProvider::HOME);

        $this->assertAuthenticated();
    }

    /** @test */
    public function users_can_not_authenticate_with_invalid_password(): void
    {
        $user = UserFactory::new()->create();

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
