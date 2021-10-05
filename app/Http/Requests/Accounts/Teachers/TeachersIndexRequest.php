<?php

namespace App\Http\Requests\Accounts\Teachers;

use Domains\Accounts\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class TeachersIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('listTeacherAccounts', User::class);
    }

    public function rules(): array
    {
        return [];
    }
}
