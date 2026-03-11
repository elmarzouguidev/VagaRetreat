<?php

namespace App\Http\Requests\Tour;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'plan_date' => ['nullable', 'date'],
            'start_at' => ['nullable', 'date_format:H:i'],
            'end_at' => ['nullable', 'date_format:H:i', 'after:start_at'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
