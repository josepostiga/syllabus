<?php

namespace App\Http\Requests\Accounts\Teachers;

use Illuminate\Foundation\Http\FormRequest;

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
            'email' => ['required', 'email', 'unique:users'],
        ];
    }
}
