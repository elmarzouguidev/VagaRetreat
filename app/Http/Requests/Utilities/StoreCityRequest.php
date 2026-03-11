<?php

namespace App\Http\Requests\Utilities;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:cities,slug'],
            'country_id' => ['nullable', 'exists:countries,id'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
