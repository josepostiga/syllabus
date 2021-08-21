<?php

namespace App\Http\Requests\Accounts\Teachers;

use Domains\Accounts\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class TeachersStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('createTeacherAccounts', User::class);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
        ];
    }
}
