<?php

namespace Tests\Feature\Controllers\Auth;

use Domains\Accounts\Database\Factories\UserFactory;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PasswordResetLinkControllerTest extends TestCase
{
    public function test_reset_password_link_screen_can_be_rendered(): void
    {
        $this->get(route('password.request'))
            ->assertStatus(Response::HTTP_OK);
    }

    public function test_reset_password_link_can_be_requested(): void
    {
        Notification::fake();

        $user = UserFactory::new()->create();

        $this->post(route('password.email'), ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_reset_password_screen_can_be_rendered(): void
    {
        Notification::fake();

        $user = UserFactory::new()->create();

        $this->post(route('password.email'), ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
            $this->get(route('password.reset', [$notification->token]))
                ->assertStatus(Response::HTTP_OK);

            return true;
        });
    }
}
