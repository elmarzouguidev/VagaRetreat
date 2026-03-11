@extends('layouts.admin')

@section('title', 'Create Tour')
@section('page-title', 'Create Tour')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div>
            <x-admin.button href="{{ route('admin.tours.index') }}" variant="outline">Back to Tours</x-admin.button>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="text-lg font-medium text-slate-900">New Tour Package</h2>
                <p class="text-sm text-slate-500 mt-1">Configure the main details of the tour. Accommodations and prices can be added later.</p>
            </div>
            <form method="POST" action="{{ route('admin.tours.store') }}" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <x-admin.form-input label="Title" name="title" required />
                     <x-admin.form-input label="Slug" name="slug" placeholder="Leave blank for auto-generation" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <x-admin.form-input label="Location" name="location" placeholder="e.g. Atlas Mountains, Morocco" />
                     <x-admin.form-input label="Duration (Days)" name="duration_days" type="number" value="1" required />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <x-admin.form-input label="Start Date" name="start_at" type="date" />
                     <x-admin.form-input label="End Date" name="end_at" type="date" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <x-admin.form-input label="Max Adults" name="adults_count" type="number" value="1" required />
                     <x-admin.form-input label="Max Children" name="children_count" type="number" value="0" required />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5" for="category_ids">Categories</label>
                        <select name="category_ids[]" id="category_ids" multiple class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-lg text-sm text-slate-900 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all duration-200 h-32">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ in_array($category->id, old('category_ids', [])) ? 'selected' : '' }}>
                                    {{ $category->label ?? $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-slate-500">Hold Cmd/Ctrl to select multiple.</p>
                     </div>
                     <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5" for="city_ids">Cities</label>
                        <select name="city_ids[]" id="city_ids" multiple class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-lg text-sm text-slate-900 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all duration-200 h-32">
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ in_array($city->id, old('city_ids', [])) ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                     </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Thumbnail</label>
                    <input type="file" name="thumbnail" accept="image/*" class="w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded-lg text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 focus:outline-none focus:ring-4 focus:ring-blue-500/10 transition-all duration-200">
                    @error('thumbnail')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
               
                <x-admin.textarea label="Excerpt" name="excerpt" rows="2" placeholder="Brief summary to show in listings" />
                <x-admin.tinymce-editor label="Description" name="description" :value="old('description', '')" required />

                <div class="flex flex-col gap-3 py-4 border-t border-slate-100">
                    <label class="flex items-center gap-3 text-sm text-slate-700 font-medium">
                        <input type="checkbox" name="is_featured" value="1" class="w-5 h-5 rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500/20">
                        Featured Tour (shows on homepage)
                    </label>
                    <label class="flex items-center gap-3 text-sm text-slate-700 font-medium">
                        <input type="checkbox" name="is_active" value="1" class="w-5 h-5 rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500/20" checked>
                        Active (published and bookable)
                    </label>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                    <x-admin.button href="{{ route('admin.tours.index') }}" variant="outline">Cancel</x-admin.button>
                    <x-admin.button type="submit" variant="primary">Create Tour</x-admin.button>
                </div>
            </form>
        </div>
    </div>
@endsection
