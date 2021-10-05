<?php

namespace App\Http\Requests\Accounts\Teachers;

use Domains\Accounts\Enums\UserRolesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeachersUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('updateTeacherAccounts', $this->route('teacher'));
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->route('teacher')->id),
            ],
            'role' => ['required', 'in:'.UserRolesEnum::TEACHER.','.UserRolesEnum::HEADTEACHER],
        ];
    }
}
