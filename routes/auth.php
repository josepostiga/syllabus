<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])
    ->group(static function (Registrar $router) {
        $router->get('/login', [AuthenticatedSessionController::class, 'create'])
            ->name('login');

        $router->post('/login', [AuthenticatedSessionController::class, 'store']);

        $router->get('/forgot-password', [PasswordResetLinkController::class, 'create'])
            ->name('password.request');

        $router->post('/forgot-password', [PasswordResetLinkController::class, 'store'])
            ->name('password.email');

        $router->get('/reset-password/{token}', [NewPasswordController::class, 'create'])
            ->name('password.reset');

        $router->post('/reset-password', [NewPasswordController::class, 'store'])
            ->name('password.update');
    });

Route::middleware(['auth'])
    ->group(static function (Registrar $router) {
        $router->get('/verify-email', EmailVerificationPromptController::class)
            ->name('verification.notice');

        $router->get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
            ->name('password.confirm');

        $router->post('/confirm-password', [ConfirmablePasswordController::class, 'store']);

        $router->post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
    });

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');
