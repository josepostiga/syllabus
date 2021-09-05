<?php

namespace App\Http\Requests\Accounts\Teachers;

use Illuminate\Foundation\Http\FormRequest;

class TeachersDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('deleteTeacherAccounts', $this->route('teacher'));
    }

    public function rules(): array
    {
        return [];
    }
}
