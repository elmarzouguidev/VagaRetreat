@extends('layouts.admin')

@section('title', 'Tours')
@section('page-title', 'Tours')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Tour Packages</h1>
                <p class="mt-1 text-sm text-slate-600">All retreat packages on VagaRetreat.</p>
            </div>
            <x-admin.button :href="route('admin.tours.create')" variant="primary">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Tour
            </x-admin.button>
        </div>

        @if(session('success'))
            <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Tour</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Destinations</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Categories</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Rooms</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Bookings</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Dates</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($tours as $tour)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.tours.show', $tour) }}" class="text-sm font-medium text-slate-900 hover:text-blue-600 transition">
                                                {{ Str::limit($tour->title, 40) }}
                                            </a>
                                            @if($tour->is_active)
                                                <span class="inline-block w-2 h-2 rounded-full bg-green-500" title="Active"></span>
                                            @else
                                                <span class="inline-block w-2 h-2 rounded-full bg-slate-300" title="Draft / Inactive"></span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-slate-500 mt-0.5">by {{ $tour->user?->name ?? 'Unknown' }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($tour->cities as $city)
                                            <span class="inline-flex px-2 py-0.5 rounded-full bg-slate-100 text-[10px] font-medium text-slate-600">{{ $city->name }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($tour->categories as $category)
                                            <span class="inline-flex px-2 py-0.5 rounded-full bg-blue-50 text-[10px] font-medium text-blue-600">{{ $category->name }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-slate-900">{{ $tour->accommodations_count }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-slate-900">{{ $tour->bookings_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    {{ $tour->start_at?->format('M d') }} — {{ $tour->end_at?->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.tours.show', $tour) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">View</a>
                                        <a href="{{ route('admin.tours.edit', $tour) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">Edit</a>
                                        <form action="{{ route('admin.tours.destroy', $tour) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this tour package?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <h3 class="text-lg font-medium text-slate-900 mb-1">No Tours</h3>
                                        <p class="text-sm text-slate-500">Tours will appear here once created.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($tours->hasPages())
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 px-4 py-3">
                {{ $tours->links() }}
            </div>
        @endif
    </div>
@endsection
