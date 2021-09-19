<?php

namespace Tests\Feature\Controllers\Auth;

use App\Providers\RouteServiceProvider;
use Domains\Accounts\Database\Factories\UserFactory;
use Domains\Accounts\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use function now;
use function route;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    private User $unverifiedUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->unverifiedUser = UserFactory::new()->unverified()->create();
    }

    /** @test */
    public function email_verification_screen_can_be_rendered(): void
    {
        $this->actingAs($this->unverifiedUser)
            ->get(route('verification.notice'))
            ->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function email_can_be_verified(): void
    {
        Event::fake();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $this->unverifiedUser->id, 'hash' => sha1($this->unverifiedUser->email)]
        );

        $this->actingAs($this->unverifiedUser)
            ->get($verificationUrl)
            ->assertRedirect(RouteServiceProvider::HOME.'?verified=1');

        Event::assertDispatched(Verified::class);
        $this->assertTrue($this->unverifiedUser->fresh()->hasVerifiedEmail());
    }

    /** @test */
    public function email_is_not_verified_with_invalid_hash(): void
    {
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $this->unverifiedUser->id, 'hash' => sha1('wrong-email')]
        );

        $this->actingAs($this->unverifiedUser)->get($verificationUrl);

        $this->assertFalse($this->unverifiedUser->fresh()->hasVerifiedEmail());
    }
}
