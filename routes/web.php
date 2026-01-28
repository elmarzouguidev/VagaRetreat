<?php

use App\Http\Controllers\CMS\CMSController;
use App\Http\Controllers\Tour\TourController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Booking\BookingController;

Route::get('/', [TourController::class, 'index'])->name('home');

Route::get("/tours/{tour:slug}", [TourController::class, 'show'])->name('tours.show');

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
