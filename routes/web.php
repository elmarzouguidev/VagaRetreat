<?php

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\TourController as AdminTourController;
use App\Http\Controllers\Booking\BookingController;
use App\Http\Controllers\CMS\CMSController;
use App\Http\Controllers\CMS\ContactController;
use App\Http\Controllers\Tour\TourController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TourController::class, 'index'])->name('home');

Route::get('/tours/{tour:slug}', [TourController::class, 'show'])->name('tours.show');

// Booking Flow
Route::get('/tours/{tour:slug}/book', [BookingController::class, 'create'])->name('bookings.create');
Route::resource('bookings', BookingController::class)->except(['create']);

// CMS Routes
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [CMSController::class, 'index'])->name('index');
    Route::get('/{post:slug}', [CMSController::class, 'showPost'])->name('show');
});
Route::prefix('page')->name('cms.')->group(function () {
    Route::get('/{page:slug}', [CMSController::class, 'showPage'])->name('pages.show');
});

Route::get('/contact-us', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact-us', [ContactController::class, 'send'])->name('contact.post');

Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);

    return redirect()->back();
});

// Admin Auth
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// Admin Dashboard (protected)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:SUPERADMIN'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/tours', AdminTourController::class);
    Route::resource('tours.accommodations', \App\Http\Controllers\Admin\TourAccommodationController::class)->except(['index', 'show']);
    Route::resource('tours.plans', \App\Http\Controllers\Admin\TourPlanController::class)->except(['index', 'show']);

    Route::get('tours/{tour}/prices/create', [\App\Http\Controllers\Admin\PriceController::class, 'createForTour'])->name('tours.prices.create');
    Route::get('accommodations/{accommodation}/prices/create', [\App\Http\Controllers\Admin\PriceController::class, 'createForAccommodation'])->name('accommodations.prices.create');
    Route::post('tours/{tour}/prices', [\App\Http\Controllers\Admin\PriceController::class, 'storeForTour'])->name('tours.prices.store');
    Route::post('accommodations/{accommodation}/prices', [\App\Http\Controllers\Admin\PriceController::class, 'storeForAccommodation'])->name('accommodations.prices.store');
    Route::get('prices/{price}/edit', [\App\Http\Controllers\Admin\PriceController::class, 'edit'])->name('prices.edit');
    Route::put('prices/{price}', [\App\Http\Controllers\Admin\PriceController::class, 'update'])->name('prices.update');
    Route::delete('prices/{price}', [\App\Http\Controllers\Admin\PriceController::class, 'destroy'])->name('prices.destroy');

    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.updateStatus');

    Route::resource('/posts', AdminPostController::class);
    Route::resource('/pages', AdminPageController::class);
    
    Route::resource('/categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
    Route::resource('/cities', \App\Http\Controllers\Admin\CityController::class)->except(['show']);
    Route::resource('/amenities', \App\Http\Controllers\Admin\AmenityController::class)->except(['show']);
    
    Route::resource('/users', \App\Http\Controllers\Admin\UserController::class)->except(['show']);
});
