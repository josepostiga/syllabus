<?php

namespace Domains\Accounts;

use Domains\Accounts\Commands\CreateUserCommand;
use Domains\Accounts\Models\User;
use Domains\Accounts\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AccountsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
        $this->loadTranslationsFrom(__DIR__.'/Resources/Lang', 'accounts');

        $this->bootPolicies();

        if ($this->app->runningInConsole()) {
            $this->bootCommands();
        }
    }

    private function bootCommands(): void
    {
        $this->commands([
            CreateUserCommand::class,
        ]);
    }

    private function bootPolicies(): void
    {
        Gate::policy(User::class, UserPolicy::class);
    }
}
