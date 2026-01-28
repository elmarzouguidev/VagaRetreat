<?php

namespace App\Http\Requests\CMS\Blog\Post;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Le titre est obligatoire.',
            'title.max' => 'Le titre ne peut pas dépasser 255 caractères.',
            'content.required' => 'Le contenu est obligatoire.',
            'excerpt.max' => 'L\'extrait ne peut pas dépasser 500 caractères.',
            'featured_image.image' => 'L\'image mise en avant doit être une image.',
            'featured_image.mimes' => 'L\'image mise en avant doit être au format : jpeg, png, jpg, gif.',
            'featured_image.max' => 'L\'image mise en avant ne peut pas dépasser 2MB.',
            'category_id.exists' => 'La catégorie sélectionnée n\'existe pas.',
            'tags.array' => 'Les tags doivent être un tableau.',
            'tags.*.max' => 'Chaque tag ne peut pas dépasser 50 caractères.',
            'published_at.date' => 'La date de publication doit être une date valide.',
            'meta_title.max' => 'Le titre meta ne peut pas dépasser 60 caractères.',
            'meta_description.max' => 'La description meta ne peut pas dépasser 160 caractères.',
        ];
    }
}
