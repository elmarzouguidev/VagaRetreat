<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tour\StorePlanRequest;
use App\Http\Requests\Tour\UpdatePlanRequest;
use App\Models\Tour\TourPackage;
use App\Models\Tour\TourPackagePlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TourPlanController extends Controller
{
    public function create(TourPackage $tour): View
    {
        return view('admin.tours.plans.create', compact('tour'));
    }

    public function store(StorePlanRequest $request, TourPackage $tour): RedirectResponse
    {
        $tour->tourPlans()->create([
            'title' => $request->title,
            'description' => $request->description,
            'plan_date' => $request->plan_date,
            'start_at' => $request->start_at ? $request->plan_date . ' ' . $request->start_at : null,
            'end_at' => $request->end_at ? $request->plan_date . ' ' . $request->end_at : null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.tours.show', $tour)
            ->with('success', 'Itinerary day added successfully.');
    }

    public function edit(TourPackage $tour, TourPackagePlan $plan): View
    {
        return view('admin.tours.plans.edit', compact('tour', 'plan'));
    }

    public function update(UpdatePlanRequest $request, TourPackage $tour, TourPackagePlan $plan): RedirectResponse
    {
        $plan->update([
            'title' => $request->title,
            'description' => $request->description,
            'plan_date' => $request->plan_date,
            'start_at' => $request->start_at ? $request->plan_date . ' ' . $request->start_at : null,
            'end_at' => $request->end_at ? $request->plan_date . ' ' . $request->end_at : null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.tours.show', $tour)
            ->with('success', 'Itinerary day updated successfully.');
    }

    public function destroy(TourPackage $tour, TourPackagePlan $plan): RedirectResponse
    {
        $plan->delete();

        return redirect()->route('admin.tours.show', $tour)
            ->with('success', 'Itinerary day deleted successfully.');
    }
}
