@extends('layouts.admin')

@section('title', 'Edit Amenity: ' . $amenity->name)
@section('page-title', 'Edit Amenity')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <div>
            <x-admin.button href="{{ route('admin.amenities.index') }}" variant="outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to Amenities
            </x-admin.button>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="text-lg font-medium text-slate-900">Edit Amenity: {{ $amenity->name }}</h2>
            </div>
            
            <form method="POST" action="{{ route('admin.amenities.update', $amenity) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-admin.form-input label="Amenity Name" name="name" :value="$amenity->name" required />
                    <x-admin.form-input label="Slug" name="slug" :value="$amenity->slug" />
                </div>
                
                <div class="grid grid-cols-1 gap-6">
                    <x-admin.form-input label="Icon (SVG string or class)" name="icon" :value="$amenity->icon" />
                    <x-admin.textarea label="Description (Optional)" name="description" rows="3" :value="$amenity->description" />
                </div>

                <div class="flex flex-col gap-3 py-4 border-t border-slate-100">
                    <label class="flex items-center gap-3 text-sm text-slate-700 font-medium">
                        <input type="checkbox" name="is_active" value="1" class="w-5 h-5 rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500/20" @checked($amenity->is_active)>
                        Active (Visible on frontend selections)
                    </label>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                    <x-admin.button href="{{ route('admin.amenities.index') }}" variant="outline">Cancel</x-admin.button>
                    <x-admin.button type="submit" variant="primary">Update Amenity</x-admin.button>
                </div>
            </form>
        </div>
    </div>
@endsection
