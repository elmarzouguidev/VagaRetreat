<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Utilities\StoreCityRequest;
use App\Http\Requests\Utilities\UpdateCityRequest;
use App\Models\Utilities\City;
use App\Models\Utilities\Country;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CityController extends Controller
{
    public function index(): View
    {
        $cities = City::with('country')
            ->withCount('tourPackages')
            ->latest()
            ->paginate(15);
            
        return view('admin.cities.index', compact('cities'));
    }

    public function create(): View
    {
        $countries = Country::orderBy('name')->get();
        return view('admin.cities.create', compact('countries'));
    }

    public function store(StoreCityRequest $request): RedirectResponse
    {
        City::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'country_id' => $request->country_id,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.cities.index')
            ->with('success', 'Destination created successfully.');
    }

    public function edit(City $city): View
    {
        $countries = Country::orderBy('name')->get();
        return view('admin.cities.edit', compact('city', 'countries'));
    }

    public function update(UpdateCityRequest $request, City $city): RedirectResponse
    {
        $city->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'country_id' => $request->country_id,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.cities.index')
            ->with('success', 'Destination updated successfully.');
    }

    public function destroy(City $city): RedirectResponse
    {
        $city->delete();

        return redirect()->route('admin.cities.index')
            ->with('success', 'Destination deleted successfully.');
    }
}
