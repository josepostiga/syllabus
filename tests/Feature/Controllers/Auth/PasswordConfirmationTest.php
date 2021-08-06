<?php

namespace Tests\Feature\Controllers\Auth;

use Domains\Accounts\Database\Factories\UserFactory;
use Domains\Accounts\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use function route;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = UserFactory::new()->create();
    }

    /** @test */
    public function confirm_password_screen_can_be_rendered(): void
    {
        $this->actingAs($this->user)
            ->get(route('password.confirm'))
            ->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function password_can_be_confirmed(): void
    {
        $this->actingAs($this->user)
            ->post(route('password.confirm'), [
                'password' => 'password',
            ])
            ->assertRedirect()
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function password_is_not_confirmed_with_invalid_password(): void
    {
        $this->actingAs($this->user)
            ->post(route('password.confirm'), [
                'password' => 'wrong-password',
            ])
            ->assertSessionHasErrors(['password']);
    }
}
