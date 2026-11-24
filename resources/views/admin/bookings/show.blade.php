@extends('layouts.admin')

@section('title', 'Booking ' . $booking->booking_reference)
@section('page-title', $booking->booking_reference)

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <x-admin.button :href="route('admin.bookings.index')" variant="outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to Bookings
            </x-admin.button>
        </div>

        @if(session('success'))
            <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-sm font-medium text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-slate-900">{{ $booking->booking_reference }}</h1>
                            <p class="text-sm text-slate-600 mt-1">Booked on {{ $booking->created_at->format('M d, Y \a\t H:i') }}</p>
                        </div>
                        @php
                            $statusColors = ['PENDING' => 'bg-yellow-100 text-yellow-700', 'CONFIRMED' => 'bg-blue-100 text-blue-700', 'COMPLETED' => 'bg-green-100 text-green-700', 'CANCELLED' => 'bg-red-100 text-red-700'];
                        @endphp
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium {{ $statusColors[$booking->status->value] ?? '' }}">
                            {{ $booking->status->label() }}
                        </span>
                    </div>

                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-6 border border-blue-200 mb-6">
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-blue-600 font-medium mb-1">Guests</p>
                                <p class="text-3xl font-bold text-blue-900">{{ $booking->guests_count ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-blue-600 font-medium mb-1">Total</p>
                                <p class="text-3xl font-bold text-blue-900">${{ number_format(($booking->total_amount ?? 0) / 100, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">Tour</dt>
                            <dd class="text-sm text-slate-900 font-semibold">{{ $booking->bookable?->title ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-slate-700 mb-1">Created</dt>
                            <dd class="text-sm text-slate-900 font-semibold">{{ $booking->created_at->format('M d, Y H:i') }}</dd>
                        </div>
                    </dl>

                    @if(!empty($booking->special_requests))
                        <div class="mt-6 pt-6 border-t border-slate-200">
                            <dt class="text-sm font-medium text-slate-700 mb-2">Special Requests</dt>
                            <dd class="text-sm text-slate-700 bg-slate-50 p-4 rounded-lg">{{ $booking->special_requests }}</dd>
                        </div>
                    @endif
                </div>
            </div>

            <div class="space-y-6">
                @if($booking->customer)
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                        <div class="px-6 py-4 border-b border-slate-200">
                            <h2 class="text-lg font-semibold text-slate-900">Guest</h2>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-lg font-semibold">
                                    {{ strtoupper(substr($booking->customer->name, 0, 2)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-slate-900">{{ $booking->customer->name }}</p>
                                    <p class="text-sm text-slate-600 truncate">{{ $booking->customer->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="text-lg font-semibold text-slate-900">Update Status</h2>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-lg text-sm text-slate-900 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all duration-200">
                                @foreach(\App\Enums\Booking\BookingStatusEnums::cases() as $status)
                                    <option value="{{ $status->value }}" {{ $booking->status === $status ? 'selected' : '' }}>{{ $status->label() }}</option>
                                @endforeach
                            </select>
                            <x-admin.button type="submit" variant="primary" class="w-full justify-center">
                                Update Status
                            </x-admin.button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
