<?php

namespace App\Http\Requests\Utilities;

use App\Enums\Roles\RolesEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', new Enum(RolesEnums::class)],
            'bio' => ['nullable', 'string'],
        ];
    }
}
