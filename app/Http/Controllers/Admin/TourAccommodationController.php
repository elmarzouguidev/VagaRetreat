<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tour\StoreAccommodationRequest;
use App\Http\Requests\Tour\UpdateAccommodationRequest;
use App\Models\Tour\Accommodation;
use App\Models\Tour\TourPackage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TourAccommodationController extends Controller
{
    public function create(TourPackage $tour): View
    {
        return view('admin.tours.accommodations.create', compact('tour'));
    }

    public function store(StoreAccommodationRequest $request, TourPackage $tour): RedirectResponse
    {
        $accommodation = $tour->accommodations()->create([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->boolean('is_active'),
            'is_featured' => $request->boolean('is_featured'),
        ]);

        if ($request->hasFile('thumbnail')) {
            $accommodation->addMediaFromRequest('thumbnail')
                ->toMediaCollection('accommodation_images');
        }

        return redirect()->route('admin.tours.show', $tour)
            ->with('success', 'Accommodation added successfully.');
    }

    public function edit(TourPackage $tour, Accommodation $accommodation): View
    {
        return view('admin.tours.accommodations.edit', compact('tour', 'accommodation'));
    }

    public function update(UpdateAccommodationRequest $request, TourPackage $tour, Accommodation $accommodation): RedirectResponse
    {
        $accommodation->update([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->boolean('is_active'),
            'is_featured' => $request->boolean('is_featured'),
        ]);

        if ($request->hasFile('thumbnail')) {
            $accommodation->addMediaFromRequest('thumbnail')
                ->toMediaCollection('accommodation_images');
        }

        return redirect()->route('admin.tours.show', $tour)
            ->with('success', 'Accommodation updated successfully.');
    }

    public function destroy(TourPackage $tour, Accommodation $accommodation): RedirectResponse
    {
        $accommodation->delete();

        return redirect()->route('admin.tours.show', $tour)
            ->with('success', 'Accommodation deleted successfully.');
    }
}
