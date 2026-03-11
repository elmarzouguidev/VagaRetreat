@extends('layouts.admin')

@section('title', 'Pickups')
@section('page-title', 'Pickup Validation')

@section('content')
    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <form method="GET" action="{{ route('admin.pickups.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-slate-700 mb-1">Search</label>
                    <input id="search" name="search" type="text" value="{{ request('search') }}"
                        placeholder="Order number or client email"
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label for="pickup_status" class="block text-sm font-medium text-slate-700 mb-1">Pickup Status</label>
                    <select id="pickup_status" name="pickup_status"
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}" @selected(request('pickup_status') === $status)>
                                {{ strtoupper($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <x-admin.button type="submit">Filter</x-admin.button>
                    <x-admin.button href="{{ route('admin.pickups.index') }}" variant="outline">Reset</x-admin.button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Order</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Client</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Collect Slot</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Order Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Pickup Status</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-slate-500 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($commands as $command)
                            <tr>
                                <td class="px-4 py-3">
                                    <p class="text-sm font-semibold text-slate-900">{{ $command->command_number }}</p>
                                    <p class="text-xs text-slate-500">#{{ $command->id }}</p>
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-700">
                                    <p>{{ $command->user?->full_name ?? 'N/A' }}</p>
                                    <p class="text-xs text-slate-500">{{ $command->user?->email ?? 'N/A' }}</p>
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-700">
                                    @if ($command->panier?->collect_day)
                                        <p>{{ $command->panier->collect_day?->format('d/m/Y') }}</p>
                                        <p class="text-xs text-slate-500">
                                            {{ $command->panier->collect_time_start?->format('H:i') }} - {{ $command->panier->collect_time_end?->format('H:i') }}
                                        </p>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-700">{{ $command->status?->label() ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm">
                                    @if ($command->pickupValidation)
                                        <span class="px-2 py-1 rounded text-xs font-medium bg-slate-100 text-slate-700">
                                            {{ strtoupper($command->pickupValidation->status) }}
                                        </span>
                                    @else
                                        <span class="text-slate-500">Not issued</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <x-admin.button href="{{ route('admin.pickups.show', $command) }}" variant="outline">
                                        Open
                                    </x-admin.button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-slate-500">No pickup records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            {{ $commands->links() }}
        </div>
    </div>
@endsection
