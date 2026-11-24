<?php

namespace App\Http\Requests\Booking;

use App\Enums\Booking\BookingStatusEnums;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookingRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['sometimes', Rule::enum(BookingStatusEnums::class)],
            'booking_date' => ['sometimes', 'date'],
            'customer_name' => ['sometimes', 'string', 'max:255'],
            'customer_email' => ['sometimes', 'email', 'max:255'],
            'customer_phone' => ['sometimes', 'string', 'max:20'],
            'customer_country' => ['sometimes', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
            'is_valid' => ['sometimes', 'boolean'],
        ];
    }
}
