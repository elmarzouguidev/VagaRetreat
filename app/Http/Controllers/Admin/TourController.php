<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tour\StoreTourRequest;
use App\Http\Requests\Tour\UpdateTourRequest;
use App\Models\Tour\TourPackage;
use App\Models\Utilities\Category;
use App\Models\Utilities\City;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class TourController extends Controller
{
    public function index(): View
    {
        $tours = TourPackage::query()
            ->with(['cities', 'categories', 'user'])
            ->withCount(['accommodations', 'bookings'])
            ->latest()
            ->paginate(10);

        return view('admin.tours.index', compact('tours'));
    }

    public function create(): View
    {
        $categories = Category::all();
        $cities = City::all();
        
        return view('admin.tours.create', compact('categories', 'cities'));
    }

    public function store(StoreTourRequest $request): RedirectResponse
    {
        $data = $request->validated();
        
        $tour = new TourPackage();
        $tour->title = $data['title'];
        $tour->slug = $data['slug'] ?? \Str::slug($data['title']);
        $tour->location = $data['location'] ?? null;
        $tour->duration_days = $data['duration_days'];
        $tour->start_at = $data['start_at'] ?? null;
        $tour->end_at = $data['end_at'] ?? null;
        $tour->excerpt = $data['excerpt'] ?? null;
        $tour->description = $data['description'];
        $tour->adults_count = $data['adults_count'];
        $tour->children_count = $data['children_count'];
        $tour->is_featured = $request->boolean('is_featured');
        $tour->is_active = $request->boolean('is_active');
        $tour->user_id = Auth::id();
        $tour->save();

        if ($request->filled('category_ids')) {
            $tour->categories()->sync($data['category_ids']);
        }

        if ($request->filled('city_ids')) {
            $tour->cities()->sync($data['city_ids']);
        }

        if ($request->hasFile('thumbnail')) {
            $tour->addMediaFromRequest('thumbnail')
                 ->toMediaCollection('tour_package_images');
        }

        return redirect()->route('admin.tours.index')
            ->with('success', 'Tour created successfully.');
    }

    public function show(TourPackage $tour): View
    {
        $tour->load(['cities', 'categories', 'user', 'accommodations.prices', 'bookings.customer', 'media']);

        return view('admin.tours.show', compact('tour'));
    }

    public function edit(TourPackage $tour): View
    {
        $categories = Category::all();
        $cities = City::all();
        $tour->load(['categories', 'cities']);
        
        $currentCategoryIds = $tour->categories->pluck('id')->toArray();
        $currentCityIds = $tour->cities->pluck('id')->toArray();

        return view('admin.tours.edit', compact('tour', 'categories', 'cities', 'currentCategoryIds', 'currentCityIds'));
    }

    public function update(UpdateTourRequest $request, TourPackage $tour): RedirectResponse
    {
        $data = $request->validated();
        
        $tour->title = $data['title'];
        if (!empty($data['slug'])) {
            $tour->slug = $data['slug'];
        }
        $tour->location = $data['location'] ?? null;
        $tour->duration_days = $data['duration_days'];
        $tour->start_at = $data['start_at'] ?? null;
        $tour->end_at = $data['end_at'] ?? null;
        $tour->excerpt = $data['excerpt'] ?? null;
        $tour->description = $data['description'];
        $tour->adults_count = $data['adults_count'];
        $tour->children_count = $data['children_count'];
        $tour->is_featured = $request->boolean('is_featured');
        $tour->is_active = $request->boolean('is_active');
        $tour->save();

        if ($request->filled('category_ids')) {
            $tour->categories()->sync($data['category_ids']);
        } else {
            $tour->categories()->detach();
        }

        if ($request->filled('city_ids')) {
            $tour->cities()->sync($data['city_ids']);
        } else {
            $tour->cities()->detach();
        }

        if ($request->hasFile('thumbnail')) {
            $tour->clearMediaCollection('tour_package_images');
            $tour->addMediaFromRequest('thumbnail')
                 ->toMediaCollection('tour_package_images');
        }

        return redirect()->route('admin.tours.index')
            ->with('success', 'Tour updated successfully.');
    }

    public function destroy(TourPackage $tour): RedirectResponse
    {
        $tour->delete();

        return redirect()->route('admin.tours.index')
            ->with('success', 'Tour deleted successfully.');
    }
}
