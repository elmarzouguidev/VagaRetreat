@extends('layouts.admin')

@section('title', 'Bookings')
@section('page-title', 'Bookings')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Booking Management</h1>
                <p class="mt-1 text-sm text-slate-600">View and manage all guest reservations.</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <form method="GET" action="{{ route('admin.bookings.index') }}" class="space-y-4 sm:space-y-0 sm:flex sm:items-end sm:gap-4">
                <div class="sm:w-48">
                    <label for="status" class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                    <select id="status" name="status" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <option value="">All Statuses</option>
                        @foreach(\App\Enums\Booking\BookingStatusEnums::cases() as $status)
                            <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <x-admin.button type="submit" variant="primary">Filter</x-admin.button>
                    @if(request()->hasAny(['status']))
                        <x-admin.button :href="route('admin.bookings.index')" variant="outline">Reset</x-admin.button>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Reference</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Guest</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Tour</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.bookings.show', $booking) }}" class="text-sm font-medium text-slate-900 hover:text-blue-600 transition">
                                        {{ $booking->booking_reference }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    @if($booking->customer)
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-semibold text-slate-700">
                                                {{ strtoupper(substr($booking->customer->name, 0, 2)) }}
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-medium text-slate-900 truncate">{{ $booking->customer->name }}</p>
                                                <p class="text-xs text-slate-500 truncate">{{ $booking->customer->email }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-slate-400 text-sm">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ Str::limit($booking->bookable?->title ?? '—', 35) }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = ['PENDING' => 'bg-yellow-100 text-yellow-700', 'CONFIRMED' => 'bg-blue-100 text-blue-700', 'COMPLETED' => 'bg-green-100 text-green-700', 'CANCELLED' => 'bg-red-100 text-red-700'];
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusColors[$booking->status->value] ?? '' }}">
                                        {{ $booking->status->label() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $booking->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <a href="{{ route('admin.bookings.show', $booking) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <h3 class="text-lg font-medium text-slate-900 mb-1">No Bookings</h3>
                                        <p class="text-sm text-slate-500">Bookings will appear once guests make reservations.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($bookings->hasPages())
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 px-4 py-3">
                {{ $bookings->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection
