<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\StoreBookingRequest;
use App\Http\Requests\Booking\UpdateBookingRequest;
use App\Models\Booking\Booking;
use App\Models\Tour\TourPackage;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(TourPackage $tour)
    {
        $tour->load(['accommodations.prices', 'prices']);
        return view('bookings.create', ['tour' => $tour]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request)
    {
        $booking = Booking::create($request->validated());
        $booking->refresh();

        return response()->json([
            'message' => 'Booking created successfully.',
            'booking' => $booking
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        return $booking;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $booking->update($request->validated());
        $booking->refresh();

        return response()->json([
            'message' => 'Booking updated successfully.',
            'booking' => $booking
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return response()->json([
            'message' => 'Booking deleted successfully.',
            'booking' => $booking
        ], 200);
    }
}
