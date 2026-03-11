<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking\Booking;
use App\Models\CMS\Page;
use App\Models\CMS\Post;
use App\Models\Tour\TourPackage;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'tours' => TourPackage::count(),
            'bookings' => Booking::count(),
            'posts' => Post::count(),
            'pages' => Page::count(),
        ];

        $recentBookings = Booking::query()
            ->with(['bookable', 'customer', 'price'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings'));
    }
}
