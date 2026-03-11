@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="space-y-6">
        <div class="admin-card p-6">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Welcome, {{ auth()?->user()?->name ?? 'Admin' }}
                    </h1>
                    <p class="mt-1 text-sm text-slate-600">
                        Overview of tours, bookings, posts and pages on VagaRetreat.
                    </p>
                </div>
                <div class="text-sm text-slate-500">
                    {{ now()->format('l, F j, Y') }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
            <x-admin.stats-card title="Tours" :value="number_format($stats['tours'])" color="blue"
                :href="route('admin.tours.index')" button-text="View Tours">
                <x-slot name="icon">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </x-slot>
            </x-admin.stats-card>

            <x-admin.stats-card title="Bookings" :value="number_format($stats['bookings'])" color="green"
                :href="route('admin.bookings.index')" button-text="View Bookings">
                <x-slot name="icon">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </x-slot>
            </x-admin.stats-card>

            <x-admin.stats-card title="Posts" :value="number_format($stats['posts'])" color="purple"
                :href="route('admin.posts.index')" button-text="View Posts">
                <x-slot name="icon">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </x-slot>
            </x-admin.stats-card>

            <x-admin.stats-card title="Pages" :value="number_format($stats['pages'])" color="amber"
                :href="route('admin.pages.index')" button-text="View Pages">
                <x-slot name="icon">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </x-slot>
            </x-admin.stats-card>
        </div>

        <!-- Recent Bookings -->
        <div class="admin-card">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-900">Recent Bookings</h3>
                <x-admin.button :href="route('admin.bookings.index')" variant="outline">View All</x-admin.button>
            </div>
            <div class="divide-y divide-slate-200">
                @forelse($recentBookings as $booking)
                    <div class="px-6 py-4 hover:bg-slate-50/70 transition">
                        <div class="flex items-center justify-between gap-4">
                            <div class="min-w-0">
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="text-sm font-medium text-slate-900 hover:text-blue-600 transition">
                                    {{ $booking->booking_reference }}
                                </a>
                                <p class="mt-1 text-xs text-slate-600">
                                    {{ $booking->customer?->name ?? 'Unknown guest' }} • {{ $booking->bookable?->title ?? 'Unknown tour' }}
                                </p>
                                <p class="mt-1 text-xs text-slate-500">{{ $booking->created_at?->diffForHumans() }}</p>
                            </div>
                            @php
                                $statusColors = [
                                    'PENDING' => 'bg-yellow-100 text-yellow-700',
                                    'CONFIRMED' => 'bg-blue-100 text-blue-700',
                                    'COMPLETED' => 'bg-green-100 text-green-700',
                                    'CANCELLED' => 'bg-red-100 text-red-700',
                                ];
                            @endphp
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusColors[$booking->status->value] ?? 'bg-slate-100 text-slate-700' }}">
                                {{ $booking->status->label() }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center text-sm text-slate-500">No bookings yet.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
