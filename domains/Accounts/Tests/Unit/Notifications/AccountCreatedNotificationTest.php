<?php

namespace Domains\Accounts\Tests\Unit\Notifications;

use Domains\Accounts\Notifications\AccountCreatedNotification;
use Tests\TestCase;

class AccountCreatedNotificationTest extends TestCase
{
    private AccountCreatedNotification $notification;

    protected function setUp(): void
    {
        parent::setUp();

        $this->notification = new AccountCreatedNotification();
    }

    /** @test */
    public function its_sent_by_mail(): void
    {
        self::assertContains('mail', $this->notification->via());
    }
}
