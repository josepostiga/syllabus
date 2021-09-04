<?php

use App\Http\Controllers\Accounts\TeachersController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

Route::prefix('/accounts')
    ->as('accounts.')
    ->middleware(['auth'])
    ->group(static function (Registrar $router) {
        $router->get('/teachers/create', [TeachersController::class, 'create'])->name('teachers.create');
        $router->post('/teachers', [TeachersController::class, 'store'])->name('teachers.store');
        $router->get('/teachers', [TeachersController::class, 'index'])->name('teachers.index');
    });