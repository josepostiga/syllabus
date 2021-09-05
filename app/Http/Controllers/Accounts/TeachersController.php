<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounts\Teachers\TeachersCreateRequest;
use App\Http\Requests\Accounts\Teachers\TeachersDeleteRequest;
use App\Http\Requests\Accounts\Teachers\TeachersIndexRequest;
use App\Http\Requests\Accounts\Teachers\TeachersShowRequest;
use App\Http\Requests\Accounts\Teachers\TeachersStoreRequest;
use App\Http\Requests\Accounts\Teachers\TeachersUpdateRequest;
use Domains\Accounts\Enums\UserRolesEnum;
use Domains\Accounts\Models\User;
use Domains\Accounts\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TeachersController extends Controller
{
    public function __construct(
        private UserRepository $repository
    ) {
    }

    public function index(TeachersIndexRequest $request): View
    {
        return view('accounts.teachers.index', [
            'teachers' => $this->repository->listTeachers(),
        ]);
    }

    public function create(TeachersCreateRequest $request): View
    {
        return view('accounts.teachers.create', [
            'roles' => [
                UserRolesEnum::HEADTEACHER => __('accounts::properties.roles.headteacher'),
                UserRolesEnum::TEACHER => __('accounts::properties.roles.teacher'),
            ],
        ]);
    }

    public function store(TeachersStoreRequest $request): RedirectResponse
    {
        $newTeacher = $this->repository->storeTeacher(
            $request->input('name'),
            $request->input('email'),
            $request->input('role'),
        );

        return redirect(route('accounts.teachers.index'))
            ->with('message', __('messages.stored', ['resource' => $newTeacher->name]));
    }

    public function show(TeachersShowRequest $request, User $teacher): View
    {
        return view('accounts.teachers.show', [
            'roles' => [
                UserRolesEnum::HEADTEACHER => __('accounts::properties.roles.headteacher'),
                UserRolesEnum::TEACHER => __('accounts::properties.roles.teacher'),
            ],
            'teacher' => $teacher,
        ]);
    }

    public function update(TeachersUpdateRequest $request, User $teacher): RedirectResponse
    {
        $updatedTeacher = $this->repository->updateTeacher(
            $teacher,
            $request->input('name'),
            $request->input('email'),
            $request->input('role'),
        );

        return redirect(route('accounts.teachers.show', $updatedTeacher))
            ->with('message', __('messages.updated', ['resource' => $updatedTeacher->name]));
    }

    public function delete(TeachersDeleteRequest $request, User $teacher): RedirectResponse
    {
        $this->repository->deleteTeacher($teacher);

        return redirect(route('accounts.teachers.index'))
            ->with('message', __('messages.deleted', ['resource' => $teacher->name]));
    }
}
