<?php

namespace App\Http\Requests\CMS\Blog\Post;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
            'content' => 'required|string|max:1000',
            'post_id' => 'required|exists:posts,id',
            'parent_id' => 'nullable|exists:comments,id',
            'author_name' => 'required_if:user_id,null|string|max:255',
            'author_email' => 'required_if:user_id,null|email|max:255',
            'user_id' => 'nullable|exists:users,id',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'content.required' => 'Le contenu du commentaire est obligatoire.',
            'content.max' => 'Le commentaire ne peut pas dépasser 1000 caractères.',
            'post_id.required' => 'L\'article est obligatoire.',
            'post_id.exists' => 'L\'article sélectionné n\'existe pas.',
            'parent_id.exists' => 'Le commentaire parent sélectionné n\'existe pas.',
            'author_name.required_if' => 'Le nom de l\'auteur est obligatoire pour les utilisateurs non connectés.',
            'author_name.max' => 'Le nom de l\'auteur ne peut pas dépasser 255 caractères.',
            'author_email.required_if' => 'L\'email de l\'auteur est obligatoire pour les utilisateurs non connectés.',
            'author_email.email' => 'L\'email de l\'auteur doit être une adresse email valide.',
            'author_email.max' => 'L\'email de l\'auteur ne peut pas dépasser 255 caractères.',
            'user_id.exists' => 'L\'utilisateur sélectionné n\'existe pas.',
        ];
    }
}
