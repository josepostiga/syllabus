<?php

namespace Tests\Feature\Controllers\Auth;

use Domains\Accounts\Database\Factories\UserFactory;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NewPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_can_be_reset_with_valid_token_and_email_is_validate(): void
    {
        Notification::fake();

        $user = UserFactory::new()->unverified()->create();

        $this->post(route('password.request'), ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
            $this->post(route('password.update'), [
                'token' => $notification->token,
                'email' => $user->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ])
                ->assertSessionHasNoErrors();

            self::assertTrue($user->fresh()->hasVerifiedEmail());

            return true;
        });
    }
}
