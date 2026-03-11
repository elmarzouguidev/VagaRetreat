<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Booking\BookingStatusEnums;
use App\Http\Controllers\Controller;
use App\Models\Booking\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(Request $request): View
    {
        $bookings = Booking::query()
            ->with(['bookable', 'customer', 'price'])
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->input('status'));
            })
            ->latest()
            ->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking): View
    {
        $booking->load(['bookable', 'customer', 'price']);

        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking): RedirectResponse
    {
        $request->validate([
            'status' => ['required', Rule::enum(BookingStatusEnums::class)],
        ]);

        $booking->update(['status' => $request->input('status')]);

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Booking status updated successfully.');
    }
}
