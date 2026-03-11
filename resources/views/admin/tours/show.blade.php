@extends('layouts.admin')

@section('title', $tour->title)
@section('page-title', 'Tour Details')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <x-admin.button :href="route('admin.tours.index')" variant="outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to Tours
            </x-admin.button>
            <a href="{{ route('tours.show', $tour) }}" target="_blank" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition">View on Site →</a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-slate-900">{{ $tour->title }}</h1>
                            <p class="text-sm text-slate-600 mt-1">by {{ $tour->user?->name ?? 'Unknown' }}</p>
                        </div>
                    </div>

                    <p class="text-sm text-slate-700 leading-relaxed mb-6">{{ $tour->description }}</p>

                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">Duration</dt>
                            <dd class="text-sm text-slate-900 font-semibold">{{ $tour->duration }} days</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">Max Group</dt>
                            <dd class="text-sm text-slate-900 font-semibold">{{ $tour->max_group_size ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">Dates</dt>
                            <dd class="text-sm text-slate-900 font-semibold">{{ $tour->start_at?->format('M d') }} — {{ $tour->end_at?->format('M d, Y') }}</dd>
                        </div>
                    </dl>

                    <div class="mt-6 pt-6 border-t border-slate-200 space-y-4">
                        <div>
                            <p class="text-sm font-medium text-slate-700 mb-2">Categories</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($tour->categories as $cat)
                                    <span class="px-3 py-1 rounded-full bg-blue-50 text-xs font-medium text-blue-600">{{ $cat->name }}</span>
                                @endforeach
                            </div>
                        </div>
                            <p class="text-sm font-medium text-slate-700 mb-2">Destinations</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($tour->cities as $city)
                                    <span class="px-3 py-1 rounded-full bg-slate-100 text-xs font-medium text-slate-600">{{ $city->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-slate-200">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-semibold text-slate-900">Base Tour Prices</h3>
                            <x-admin.button :href="route('admin.tours.prices.create', $tour)" variant="outline" class="!px-2.5 !py-1 !text-xs">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Add Price
                            </x-admin.button>
                        </div>
                        
                        @if($tour->prices->isNotEmpty())
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($tour->prices as $price)
                                    <div class="flex items-center justify-between p-3 rounded border {{ $price->is_default ? 'bg-blue-50/50 border-blue-200' : 'bg-slate-50 border-slate-200' }}">
                                        <div>
                                            <p class="text-sm font-semibold text-slate-900 flex items-center gap-1.5">
                                                {{ $price->currency->format($price->amount) }}
                                                @if($price->is_default)
                                                    <span class="px-1.5 py-0.5 rounded text-[10px] font-medium bg-blue-100 text-blue-700">Default</span>
                                                @endif
                                            </p>
                                            <p class="text-xs text-slate-500 mt-0.5">{{ $price->name }}</p>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <a href="{{ route('admin.prices.edit', $price) }}" class="p-1 text-slate-400 hover:text-blue-600 transition" title="Edit">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </a>
                                            <form action="{{ route('admin.prices.destroy', $price) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this price?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1 text-slate-400 hover:text-red-600 transition" title="Delete">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-slate-500 italic">No base prices set. The tour cannot be booked without a price.</p>
                        @endif
                    </div>
                </div>

                @if($tour->bookings->isNotEmpty())
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-6 py-4 border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-slate-900">Bookings ({{ $tour->bookings->count() }})</h2>
                        </div>
                        <div class="divide-y divide-slate-200">
                            @foreach($tour->bookings as $booking)
                                <div class="px-6 py-4 hover:bg-slate-50/70 transition">
                                    <div class="flex items-center justify-between gap-4">
                                        <div class="min-w-0">
                                            <a href="{{ route('admin.bookings.show', $booking) }}" class="text-sm font-medium text-slate-900 hover:text-blue-600">{{ $booking->booking_reference }}</a>
                                            <p class="mt-1 text-xs text-slate-500">{{ $booking->customer?->name ?? '—' }} • {{ $booking->created_at->format('M d, Y') }}</p>
                                        </div>
                                        @php
                                            $statusColors = ['PENDING' => 'bg-yellow-100 text-yellow-700', 'CONFIRMED' => 'bg-blue-100 text-blue-700', 'COMPLETED' => 'bg-green-100 text-green-700', 'CANCELLED' => 'bg-red-100 text-red-700'];
                                        @endphp
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusColors[$booking->status->value] ?? '' }}">{{ $booking->status->label() }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-slate-900">Accommodations</h2>
                        <x-admin.button :href="route('admin.tours.accommodations.create', $tour)" variant="primary" class="!px-3 !py-1.5 !text-xs">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add Option
                        </x-admin.button>
                    </div>
                    <div class="divide-y divide-slate-200">
                        @forelse($tour->accommodations as $accommodation)
                            <div class="px-6 py-4 hover:bg-slate-50 transition">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex items-center gap-4">
                                        @if($accommodation->hasMedia('accommodation_images'))
                                            <img src="{{ $accommodation->getFirstMediaUrl('accommodation_images') }}" class="w-12 h-12 rounded object-cover border border-slate-200" alt="{{ $accommodation->name }}">
                                        @else
                                            <div class="w-12 h-12 rounded bg-slate-100 flex items-center justify-center text-slate-400 border border-slate-200">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-sm font-medium text-slate-900 flex items-center gap-2">
                                                {{ $accommodation->name }}
                                                @if($accommodation->is_featured)
                                                    <svg class="w-3.5 h-3.5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                @endif
                                            </p>
                                            <p class="text-xs text-slate-500 mt-0.5">Up to {{ $accommodation->capacity }} guests • {{ $accommodation->quantity }} available</p>
                                            
                                            <div class="mt-2.5 flex flex-wrap gap-2">
                                                @foreach($accommodation->prices as $price)
                                                    <div class="inline-flex items-center gap-1.5 px-2 py-1 rounded bg-slate-100 border border-slate-200">
                                                        <span class="text-[11px] font-semibold text-slate-700">{{ $price->currency->format($price->amount) }}</span>
                                                        <span class="text-[10px] text-slate-500">{{ $price->name }}</span>
                                                        <a href="{{ route('admin.prices.edit', $price) }}" class="text-slate-400 hover:text-blue-600 ml-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></a>
                                                        <form action="{{ route('admin.prices.destroy', $price) }}" method="POST" class="inline" onsubmit="return confirm('Delete price?');">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="text-slate-400 hover:text-red-600"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                                        </form>
                                                    </div>
                                                @endforeach
                                                <a href="{{ route('admin.accommodations.prices.create', $accommodation) }}" class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-50 border border-dashed border-slate-300 text-slate-400 hover:text-blue-600 hover:border-blue-300 hover:bg-blue-50 transition" title="Add Price">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.tours.accommodations.edit', [$tour, $accommodation]) }}" class="p-1.5 text-slate-400 hover:text-blue-600 rounded bg-white hover:bg-blue-50 border border-transparent hover:border-blue-100 transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </a>
                                        <form action="{{ route('admin.tours.accommodations.destroy', [$tour, $accommodation]) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this accommodation option?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 rounded bg-white hover:bg-red-50 border border-transparent hover:border-red-100 transition" title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-8 text-center">
                                <p class="text-sm text-slate-500">No accommodations set up yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-slate-900">Itinerary</h2>
                        <x-admin.button :href="route('admin.tours.plans.create', $tour)" variant="primary" class="!px-3 !py-1.5 !text-xs">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add Day
                        </x-admin.button>
                    </div>
                    <div class="divide-y divide-slate-200">
                        @forelse($tour->tourPlans()->orderBy('plan_date')->orderBy('start_at')->get() as $plan)
                            <div class="px-6 py-4 hover:bg-slate-50 transition">
                                <div class="flex flex-col gap-2">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-slate-900 flex items-center gap-2">
                                                {{ $plan->title }}
                                                @if(!$plan->is_active)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600">Draft</span>
                                                @endif
                                            </p>
                                            @if($plan->plan_date || $plan->start_at)
                                                <p class="text-xs font-semibold text-blue-600 mt-0.5">
                                                    @if($plan->plan_date){{ $plan->plan_date->format('M d') }}@endif
                                                    @if($plan->plan_date && $plan->start_at) • @endif
                                                    @if($plan->start_at){{ $plan->start_at->format('H:i') }} - {{ $plan->end_at ? $plan->end_at->format('H:i') : '' }}@endif
                                                </p>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-2 shrink-0">
                                            <a href="{{ route('admin.tours.plans.edit', [$tour, $plan]) }}" class="p-1.5 text-slate-400 hover:text-blue-600 rounded bg-white hover:bg-blue-50 border border-transparent hover:border-blue-100 transition" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </a>
                                            <form action="{{ route('admin.tours.plans.destroy', [$tour, $plan]) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this itinerary day?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 rounded bg-white hover:bg-red-50 border border-transparent hover:border-red-100 transition" title="Delete">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @if($plan->description)
                                        <p class="text-xs text-slate-500 line-clamp-2 mt-1">{{ $plan->description }}</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-8 text-center">
                                <p class="text-sm text-slate-500">No itinerary planned yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
