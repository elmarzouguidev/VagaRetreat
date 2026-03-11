@extends('layouts.admin')

@section('title', 'Edit Accommodation - ' . $tour->title)
@section('page-title', 'Edit Accommodation')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div>
            <x-admin.button :href="route('admin.tours.show', $tour)" variant="outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to {{ $tour->title }}
            </x-admin.button>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-semibold text-slate-900">Edit Accommodation: {{ $accommodation->name }}</h2>
            </div>
            
            <form action="{{ route('admin.tours.accommodations.update', [$tour, $accommodation]) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6 cursor-text">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <x-admin.form-input label="Name" name="name" :value="$accommodation->name" required />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                     <x-admin.form-input label="Capacity (Guests)" name="capacity" type="number" :value="$accommodation->capacity" required />
                     <x-admin.form-input label="Quantity Available" name="quantity" type="number" :value="$accommodation->quantity" required />
                     <x-admin.form-input label="Sort Order" name="sort_order" type="number" :value="$accommodation->sort_order" />
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Image / Thumbnail</label>
                    @if($accommodation->hasMedia('accommodation_images'))
                        <div class="mb-3">
                            <img src="{{ $accommodation->getFirstMediaUrl('accommodation_images') }}" class="h-24 w-auto rounded object-cover shadow-sm" alt="Current image">
                        </div>
                    @endif
                    <input type="file" name="thumbnail" accept="image/*" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-lg text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 focus:outline-none focus:ring-4 focus:ring-blue-500/10 transition-all duration-200">
                    <p class="mt-1 text-xs text-slate-500">Leave empty to keep current image.</p>
                    @error('thumbnail')
                        <p class="mt-2 text-[13px] font-medium text-red-600 flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>{{ $message }}</p>
                    @enderror
                </div>
               
                <x-admin.textarea label="Description" name="description" rows="3" :value="$accommodation->description" />

                <div class="flex flex-col gap-3 py-4 border-t border-slate-100">
                    <label class="flex items-center gap-3 text-sm text-slate-700 font-medium">
                        <input type="checkbox" name="is_featured" value="1" class="w-5 h-5 rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500/20" @checked($accommodation->is_featured)>
                        Featured Accommodation (Highlight it as recommended)
                    </label>
                    <label class="flex items-center gap-3 text-sm text-slate-700 font-medium">
                        <input type="checkbox" name="is_active" value="1" class="w-5 h-5 rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500/20" @checked($accommodation->is_active)>
                        Active (Bookable)
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                    <x-admin.button :href="route('admin.tours.show', $tour)" variant="outline">Cancel</x-admin.button>
                    <x-admin.button type="submit" variant="primary">Update Accommodation</x-admin.button>
                </div>
            </form>
        </div>
    </div>
@endsection
