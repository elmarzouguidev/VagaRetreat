<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tour\TourPackage;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $tours = TourPackage::query()
            ->with(['cities.country', 'categories', 'prices', 'accommodations']) // Eager load relationships
            ->when($request->input('country_id'), function (Builder $query, $countryId) {
                $query->whereHas('cities.country', function (Builder $query) use ($countryId) {
                    $query->where('countries.id', $countryId);
                });
            })
            ->when($request->input('category_id'), function (Builder $query, $categoryId) {
                $query->whereHas('categories', function (Builder $query) use ($categoryId) {
                    $query->where('categories.id', $categoryId);
                });
            })
            ->when($request->input('start_date'), function (Builder $query, $startDate) {
                $query->whereDate('start_at', '>=', $startDate);
            })
            ->when($request->input('end_date'), function (Builder $query, $endDate) {
                $query->whereDate('end_at', '<=', $endDate);
            })
            ->when($request->input('instructor_id'), function (Builder $query, $instructorId) {
                 // Assuming TourPackage belongsTo User (instructor)
                 $query->where('user_id', $instructorId);
            })
            ->paginate(12);

        return response()->json($tours);
    }
}
