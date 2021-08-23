<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounts\Teachers\TeachersIndexRequest;
use App\Http\Requests\Accounts\Teachers\TeachersStoreRequest;
use Domains\Accounts\Enums\UserRolesEnum;
use Domains\Accounts\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TeachersController extends Controller
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(TeachersIndexRequest $request): View
    {
        return \view('accounts.teachers.index');
    }

    public function create(): View
    {
        $teacherRoles = [
            UserRolesEnum::HEADTEACHER => __('accounts::properties.roles.headteacher'),
            UserRolesEnum::TEACHER => __('accounts::properties.roles.teacher'),
        ];

        return \view('accounts.teachers.create', [
            'roles' => $teacherRoles,
        ]);
    }

    public function store(TeachersStoreRequest $request): RedirectResponse
    {
        $newTeacher = $this->repository->storeTeacher(
            $request->input('name'),
            $request->input('email'),
        );

        return redirect(route('accounts.teachers.index'))
            ->with('message', __('messages.stored', ['resource' => $newTeacher->name]));
    }
}
