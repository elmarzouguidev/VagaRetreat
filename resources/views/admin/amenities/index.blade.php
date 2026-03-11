@extends('layouts.admin')

@section('title', 'Amenities')
@section('page-title', 'Manage Amenities')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-900">Amenities</h1>
            <x-admin.button href="{{ route('admin.amenities.create') }}" variant="primary">
                <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Amenity
            </x-admin.button>
        </div>

        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="admin-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-500 bg-slate-50 uppercase border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 font-medium">Icon & Name</th>
                            <th class="px-6 py-4 font-medium">Description</th>
                            <th class="px-6 py-4 font-medium">Status</th>
                            <th class="px-6 py-4 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($amenities as $amenity)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-6 py-4 font-medium text-slate-900 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded bg-slate-100 flex items-center justify-center text-slate-500 border border-slate-200">
                                        @if($amenity->icon)
                                            <!-- Assuming icon contains SVG or class code, here we just output it or use a default if it's a class -->
                                            {!! $amenity->icon !!}
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        @endif
                                    </div>
                                    <div class="flex flex-col">
                                        <span>{{ $amenity->name }}</span>
                                        <span class="text-[10px] text-slate-400 font-normal">{{ $amenity->slug }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-500 max-w-xs truncate" title="{{ $amenity->description }}">{{ $amenity->description ?: 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    @if($amenity->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Active</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.amenities.edit', $amenity) }}" class="p-2 text-slate-400 hover:text-blue-600 transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </a>
                                        <form action="{{ route('admin.amenities.destroy', $amenity) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this amenity?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-400 hover:text-red-600 transition" title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                                    No amenities found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($amenities->hasPages())
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $amenities->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
