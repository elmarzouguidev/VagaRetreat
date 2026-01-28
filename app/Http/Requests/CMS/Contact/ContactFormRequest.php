<?php

namespace App\Http\Requests\CMS\Contact;

use App\Rules\UnauthorizedEmailProviders;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactFormRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', Rule::when(app()->isProduction(), [new UnauthorizedEmailProviders])],
           // 'email' => ['required', 'string', 'email'],
            'message' => ['required', 'string', 'max:255']
        ];
    }
}
