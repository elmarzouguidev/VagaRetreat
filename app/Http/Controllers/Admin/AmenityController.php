<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Utilities\StoreAmenityRequest;
use App\Http\Requests\Utilities\UpdateAmenityRequest;
use App\Models\Utilities\Amenity;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AmenityController extends Controller
{
    public function index(): View
    {
        $amenities = Amenity::latest()->paginate(15);
            
        return view('admin.amenities.index', compact('amenities'));
    }

    public function create(): View
    {
        return view('admin.amenities.create');
    }

    public function store(StoreAmenityRequest $request): RedirectResponse
    {
        Amenity::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'icon' => $request->icon,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.amenities.index')
            ->with('success', 'Amenity created successfully.');
    }

    public function edit(Amenity $amenity): View
    {
        return view('admin.amenities.edit', compact('amenity'));
    }

    public function update(UpdateAmenityRequest $request, Amenity $amenity): RedirectResponse
    {
        $amenity->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'icon' => $request->icon,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.amenities.index')
            ->with('success', 'Amenity updated successfully.');
    }

    public function destroy(Amenity $amenity): RedirectResponse
    {
        $amenity->delete();

        return redirect()->route('admin.amenities.index')
            ->with('success', 'Amenity deleted successfully.');
    }
}
