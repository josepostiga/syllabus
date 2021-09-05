<?php

namespace App\Http\Requests\Accounts\Teachers;

use Illuminate\Foundation\Http\FormRequest;

class TeachersShowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('showTeacherAccounts', $this->route('teacher'));
    }

    public function rules(): array
    {
        return [];
    }
}
