<?php

namespace App\Http\Controllers\Tour;

use App\Http\Controllers\Controller;
use App\Models\Tour\TourPackage;
use App\Models\Utilities\Category;
use App\Models\Utilities\Country;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
class TourController extends Controller
{
    


    public function index(Request $request)
    {
        $tours = QueryBuilder::for(TourPackage::class)
            ->allowedFilters([
                'title',
                AllowedFilter::scope('starts_after', 'startsAfter'), // Custom scope or exact match if date
                AllowedFilter::scope('ends_before', 'endsBefore'),
                AllowedFilter::callback('country', function ($query, $value) {
                    $query->whereHas('cities.country', function ($q) use ($value) {
                        $q->whereIn('slug', (array)$value);
                    });
                }),
                AllowedFilter::callback('category', function ($query, $value) {
                    $query->whereHas('categories', function ($q) use ($value) {
                        $q->whereIn('slug', (array)$value);
                    });
                }),
            ])
            ->allowedSorts(['price', 'created_at', 'duration_days'])
            ->with(['cities.country:id,name,slug', 'categories:id,name,slug', 'prices', 'accommodations']) // Eager load
            ->where('is_active', true)
            ->paginate(12)
            ->appends(request()->query()); // Keep query params in pagination links


        $countries = Country::select(['id','name','slug'])->get();

        $activities = Category::select(['id','name','slug'])->get();
        
        if ($request->wantsJson()) {
            return response()->json($tours);
        }

        return view('tours.index', compact('countries','tours','activities'));
    }

    public function show(TourPackage $tour)
    {
        $tour->load(['categories:id,name,slug', 'cities:id,name,slug,country_id', 'prices','cities.country:id,name,slug', 'accommodations.amenities', 'accommodations.media']);
        if (request()->wantsJson()) {
            return response()->json($tour);
        }
        return view('tours.show', ['tour' => $tour]);
    }
}
