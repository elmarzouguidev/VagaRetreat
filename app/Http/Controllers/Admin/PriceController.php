<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Utilities\StorePriceRequest;
use App\Http\Requests\Utilities\UpdatePriceRequest;
use App\Models\Tour\Accommodation;
use App\Models\Tour\TourPackage;
use App\Models\Utilities\Price;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PriceController extends Controller
{
    public function createForTour(TourPackage $tour): View
    {
        $priceable = $tour;
        $type = 'tour';
        $backRoute = route('admin.tours.show', $tour);
        $storeRoute = route('admin.tours.prices.store', $tour);
        return view('admin.prices.create', compact('priceable', 'type', 'backRoute', 'storeRoute'));
    }

    public function createForAccommodation(Accommodation $accommodation): View
    {
        $priceable = $accommodation;
        $type = 'accommodation';
        $backRoute = route('admin.tours.show', $accommodation->tourPackage);
        $storeRoute = route('admin.accommodations.prices.store', $accommodation);
        return view('admin.prices.create', compact('priceable', 'type', 'backRoute', 'storeRoute'));
    }

    public function storeForTour(StorePriceRequest $request, TourPackage $tour): RedirectResponse
    {
        $this->storePrice($request, $tour);
        return redirect()->route('admin.tours.show', $tour)->with('success', 'Price added successfully.');
    }

    public function storeForAccommodation(StorePriceRequest $request, Accommodation $accommodation): RedirectResponse
    {
        $this->storePrice($request, $accommodation);
        return redirect()->route('admin.tours.show', $accommodation->tourPackage)->with('success', 'Price added successfully.');
    }

    private function storePrice(StorePriceRequest $request, $priceable): void
    {
        if ($request->boolean('is_default')) {
            $priceable->prices()->update(['is_default' => false]);
        }

        $priceable->prices()->create([
            'name' => $request->name,
            'amount' => $request->amount * 100, // To cents
            'currency' => $request->currency,
            'is_active' => $request->boolean('is_active', true),
            'is_default' => $request->boolean('is_default'),
            'expired_at' => $request->expired_at,
        ]);
    }

    public function edit(Price $price): View
    {
        $priceable = $price->priceable;
        $type = $priceable instanceof TourPackage ? 'tour' : 'accommodation';
        $backRoute = route('admin.tours.show', $type === 'tour' ? $priceable : $priceable->tourPackage);
        $updateRoute = route('admin.prices.update', $price);
        
        return view('admin.prices.edit', compact('price', 'priceable', 'type', 'backRoute', 'updateRoute'));
    }

    public function update(UpdatePriceRequest $request, Price $price): RedirectResponse
    {
        if ($request->boolean('is_default')) {
            $price->priceable->prices()->where('id', '!=', $price->id)->update(['is_default' => false]);
        }

        $price->update([
            'name' => $request->name,
            'amount' => $request->amount * 100, // To cents
            'currency' => $request->currency,
            'is_active' => $request->boolean('is_active', true),
            'is_default' => $request->boolean('is_default'),
            'expired_at' => $request->expired_at,
        ]);

        $tour = $price->priceable instanceof TourPackage ? $price->priceable : $price->priceable->tourPackage;
        return redirect()->route('admin.tours.show', $tour)->with('success', 'Price updated successfully.');
    }

    public function destroy(Price $price): RedirectResponse
    {
        $tour = $price->priceable instanceof TourPackage ? $price->priceable : $price->priceable->tourPackage;
        $price->delete();
        
        return redirect()->route('admin.tours.show', $tour)->with('success', 'Price deleted successfully.');
    }
}
