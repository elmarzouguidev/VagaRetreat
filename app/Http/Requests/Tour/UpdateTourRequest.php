<?php

namespace App\Http\Requests\Tour;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTourRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('tour_packages', 'slug')->ignore($this->tour),
            ],
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'location' => 'nullable|string|max:255',
            'duration_days' => 'required|integer|min:0',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'excerpt' => 'nullable|string|max:500',
            'description' => 'required|string',
            'adults_count' => 'required|integer|min:1',
            'children_count' => 'required|integer|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
            'city_ids' => 'nullable|array',
            'city_ids.*' => 'exists:cities,id',
        ];
    }
}
