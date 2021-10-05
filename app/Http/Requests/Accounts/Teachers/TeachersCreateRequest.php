<?php

namespace App\Http\Requests\Accounts\Teachers;

use Domains\Accounts\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class TeachersCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('createTeacherAccounts', User::class);
    }

    public function rules(): array
    {
        return [];
    }
}
