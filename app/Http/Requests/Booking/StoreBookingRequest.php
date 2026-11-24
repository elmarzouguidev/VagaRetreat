<?php

namespace App\Http\Requests\Booking;

use App\Models\Tour\Accommodation;
use App\Models\Tour\TourPackage;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
{
    /**
     * Allowed bookable models for polymorphic booking.
     *
     * @var array<int, class-string>
     */
    public const ALLOWED_BOOKABLES = [
        TourPackage::class,
        Accommodation::class,
    ];

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
            'bookable_type' => ['required', 'string', Rule::in(self::ALLOWED_BOOKABLES)],
            'bookable_id' => ['required', 'integer'],
            'price_id' => ['required', 'exists:prices,id'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'customer_country' => ['required', 'string', 'max:255'],
        ];
    }
}
