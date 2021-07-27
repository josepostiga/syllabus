<?php

namespace Domains\Accounts;

use Illuminate\Auth\Events\Registered as UserRegistered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AccountsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerEvents();
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }

    private function registerEvents(): void
    {
        Event::listen(UserRegistered::class, [
            SendEmailVerificationNotification::class,
        ]);
    }
}
