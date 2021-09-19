<?php

namespace Domains\Accounts\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountCreatedNotification extends Notification
{
    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage())
            ->subject(__('accounts::account_created_notification.subject'))
            ->line(__('accounts::account_created_notification.line_1'))
            ->action(__('accounts::account_created_notification.action'), route('password.request'))
            ->line(__('accounts::account_created_notification.line_2'));
    }
}
